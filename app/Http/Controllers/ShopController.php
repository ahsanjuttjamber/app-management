<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\CustomerDevice;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class ShopController extends Controller
{
    public function showSignup()
    {
        return view('shop_signup');
    }

    // ✅ FIXED: Ab email bhi jaayegi
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'shop_name' => 'required|string',
            'address'   => 'required|string',
            'phone'     => 'required|string',
            'email'     => 'required|email|unique:shops,email',
            'password'  => 'required|min:6|confirmed',
        ]);

        $otp = rand(100000, 999999);

        // Shop save karo
        $shop = new Shop();
        $shop->name      = $request->name;
        $shop->shop_name = $request->shop_name;
        $shop->address   = $request->address;
        $shop->phone     = $request->phone;
        $shop->email     = $request->email;
        $shop->password  = Hash::make($request->password);
        $shop->otp       = $otp;
        $shop->is_approved = false;
        $shop->save();

        // OTP table mein save karo
        Otp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp'         => $otp,
                'expires_at'  => now()->addMinutes(10),
                'is_verified' => false,
            ]
        );

        // ✅ EMAIL BHEJO
        try {
            Mail::to($request->email)->send(new OtpMail($otp, $request->name));
            Log::info('OTP email sent to: ' . $request->email);
        } catch (\Exception $e) {
            Log::error('OTP email failed: ' . $e->getMessage());
            // Email fail ho toh bhi aage jao — OTP database mein hai
        }

        session(['otp_email' => $request->email]);

        return redirect('/otp-verify')->with('success', 'Registration successful! OTP sent to your email.');
    }

    public function showOtpForm()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect('/shop-signup')->with('error', 'Please signup first');
        }
        return view('otp_verify', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric'
        ]);

        $otpRecord = Otp::where('email', $request->email)
                        ->where('otp', $request->otp)
                        ->where('expires_at', '>', now())
                        ->first();

        if ($otpRecord) {
            $otpRecord->update(['is_verified' => true]);
            return redirect('/waiting-approval');
        }

        return back()->with('error', 'Invalid or expired OTP. Please try again.');
    }

    public function waitingApproval()
    {
        return view('waiting_approval');
    }

    public function showLogin()
    {
        return view('shop_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $shop = Shop::where('email', $request->email)->first();

        if ($shop && Hash::check($request->password, $shop->password)) {
            if (!$shop->is_approved) {
                return back()->with('error', 'Your account is pending admin approval.');
            }
            session(['shop_logged_in' => true, 'shop_id' => $shop->id]);
            return redirect('/shop-dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function dashboard()
    {
        $shopId = session('shop_id');
        $shop   = Shop::find($shopId);

        if (!$shop->is_active) {
            return view('shop_blocked');
        }

        $devices = CustomerDevice::where('shop_id', $shopId)->get();
        return view('shop_dashboard', compact('shop', 'devices'));
    }

    public function addDevice(Request $request)
    {
        $shopId = $request->input('shop_id') ?? session('shop_id');

        $request->validate([
            'customer_name' => 'required|string',
            'mobile_name'   => 'required|string',
            'phone_number'  => 'required|string',
            'device_id'     => 'required|string|unique:customer_devices,device_id',
        ]);

        CustomerDevice::create([
            'device_id'     => $request->device_id,
            'customer_name' => $request->customer_name,
            'phone_number'  => $request->phone_number,
            'mobile_name'   => $request->mobile_name,
            'shop_id'       => $shopId,
            'status'        => 'active',
            'lock_type'     => 'soft',
            'is_blocked'    => false,
            'is_fully_paid' => false,
        ]);

        return redirect()->back()->with('success', 'Device added successfully');
    }

    public function lock($id)
    {
        $device = CustomerDevice::findOrFail($id);
        $device->update([
            'is_blocked' => true,
            'lock_type'  => 'full',
            'status'     => 'full_lock'
        ]);

        try {
            Http::timeout(5)->post('https://comfortable-unity-production-7a5f.up.railway.app/api/emi/admin/full-lock', [
                'device_id' => $device->device_id
            ]);
        } catch (\Exception $e) {
            Log::error('Lock API failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Device locked successfully');
    }

    public function unlock($id)
    {
        $device = CustomerDevice::findOrFail($id);
        $device->update([
            'is_blocked' => false,
            'status'     => 'active',
            'lock_type'  => 'soft'
        ]);

        try {
            Http::timeout(5)->post('https://comfortable-unity-production-7a5f.up.railway.app/api/emi/admin/unblock', [
                'device_id' => $device->device_id
            ]);
        } catch (\Exception $e) {
            Log::error('Unlock API failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Device unlocked successfully');
    }

    public function deleteDevice($id)
    {
        CustomerDevice::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Device deleted successfully');
    }

    public function getLocation($device_id)
    {
        $device = CustomerDevice::where('device_id', $device_id)->first();

        if ($device && $device->last_latitude && $device->last_longitude) {
            return response()->json([
                'latitude'        => $device->last_latitude,
                'longitude'       => $device->last_longitude,
                'last_location_at'=> $device->last_location_at
            ]);
        }

        return response()->json(['latitude' => null, 'longitude' => null]);
    }

    public function logout()
    {
        session()->forget(['shop_logged_in', 'shop_id']);
        return redirect('/shop-login');
    }

    // ✅ FIXED: resendOtp ab Request use karta hai (POST se email milti hai)
    public function resendOtp(Request $request)
    {
        $email = $request->email ?? session('otp_email');

        $shop = Shop::where('email', $email)->first();

        if (!$shop) {
            return response()->json(['success' => false, 'message' => 'Email not found']);
        }

        $otp = rand(100000, 999999);

        $shop->otp = $otp;
        $shop->save();

        Otp::updateOrCreate(
            ['email' => $email],
            [
                'otp'         => $otp,
                'expires_at'  => now()->addMinutes(10),
                'is_verified' => false,
            ]
        );

        // ✅ EMAIL BHEJO
        try {
            Mail::to($email)->send(new OtpMail($otp, $shop->name));
            return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            Log::error('Resend OTP email failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Email sending failed: ' . $e->getMessage()]);
        }
    }
}
