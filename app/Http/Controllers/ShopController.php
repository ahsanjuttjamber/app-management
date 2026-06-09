<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\CustomerDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    // Show signup form
    public function showSignup()
    {
        return view('shop_signup');
    }

    // Register new shop owner
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'shop_name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:shops,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Shop::create([
            'name' => $request->name,
            'shop_name' => $request->shop_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Registration successful! Wait for admin approval.');
    }

    // Show login form
    public function showLogin()
    {
        return view('shop_login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
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

    // Show dashboard with shop's own devices
    public function dashboard()
    {
        $shopId = session('shop_id');
        $shop = Shop::find($shopId);
        $devices = CustomerDevice::where('shop_id', $shopId)->get();
        return view('shop_dashboard', compact('shop', 'devices'));
    }

    // Add device for this shop (FIXED: shop_id fallback)
public function addDevice(Request $request)
{
    // FORM SE SHOP_ID LO (most important)
    $shopId = $request->input('shop_id');

    // Agar form se nahi aaya to session se lo
    if (!$shopId) {
        $shopId = session('shop_id');
    }

    // Log for debugging
    Log::info('Shop ID from form: ' . $request->input('shop_id'));
    Log::info('Shop ID from session: ' . session('shop_id'));
    Log::info('Final Shop ID: ' . $shopId);

    $request->validate([
        'customer_name' => 'required|string',
        'mobile_name'   => 'required|string',
        'phone_number'  => 'required|string',
        'device_id'     => 'required|string|unique:customer_devices,device_id',
    ]);

    CustomerDevice::create([
        'device_id'      => $request->device_id,
        'customer_name'  => $request->customer_name,
        'phone_number'   => $request->phone_number,
        'mobile_name'    => $request->mobile_name,
        'shop_id'        => $shopId,  // ✅ Yahan form se aaya hua shop_id use hoga
        'status'         => 'active',
        'lock_type'      => 'soft',
        'is_blocked'     => false,
        'is_fully_paid'  => false,
    ]);

    return redirect()->back()->with('success', 'Device added successfully');
}

    // Lock device
    public function lock($id)
    {
        $device = CustomerDevice::findOrFail($id);

        $device->update([
            'is_blocked' => true,
            'lock_type' => 'full',
            'status' => 'full_lock'
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

    // Unlock device
    public function unlock($id)
    {
        $device = CustomerDevice::findOrFail($id);

        $device->update([
            'is_blocked' => false,
            'status' => 'active',
            'lock_type' => 'soft'
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

    // Delete device
    public function deleteDevice($id)
    {
        $device = CustomerDevice::findOrFail($id);
        $device->delete();
        return redirect()->back()->with('success', 'Device deleted successfully');
    }

    // Get device location
    public function getLocation($device_id)
    {
        $device = CustomerDevice::where('device_id', $device_id)->first();

        if ($device && $device->last_latitude && $device->last_longitude) {
            return response()->json([
                'latitude' => $device->last_latitude,
                'longitude' => $device->last_longitude,
                'last_location_at' => $device->last_location_at
            ]);
        }

        return response()->json(['latitude' => null, 'longitude' => null]);
    }

    // Logout
    public function logout()
    {
        session()->forget(['shop_logged_in', 'shop_id']);
        return redirect('/shop-login');
    }
}
