<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    // Show dashboard with all devices
    public function index()
    {
        $devices = CustomerDevice::all();
        return view('admin.dashboard', compact('devices'));
    }

    // Lock device
    public function lock($id)
    {
        $device = CustomerDevice::findOrFail($id);

        // Update local database
        $device->update([
            'is_blocked' => true,
            'lock_type' => 'full',
            'status' => 'full_lock'
        ]);

        // Call Railway API to lock the phone
        Http::post('https://comfortable-unity-production-7a5f.up.railway.app/api/emi/admin/full-lock', [
            'device_id' => $device->device_id
        ]);

        return redirect()->back()->with('success', 'Device locked successfully');
    }

    // Unlock device
    public function unlock($id)
    {
        $device = CustomerDevice::findOrFail($id);

        // Update local database
        $device->update([
            'is_blocked' => false,
            'status' => 'active',
            'lock_type' => 'soft'
        ]);

        // Call Railway API to unlock the phone
        Http::post('https://comfortable-unity-production-7a5f.up.railway.app/api/emi/admin/unblock', [
            'device_id' => $device->device_id
        ]);

        return redirect()->back()->with('success', 'Device unlocked successfully');
    }
}
