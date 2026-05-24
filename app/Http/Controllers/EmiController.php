<?php

namespace App\Http\Controllers;

use App\Models\CustomerDevice;
use Illuminate\Http\Request;

class EmiController extends Controller
{
    // ✅ 1. Device Register
    public function registerDevice(Request $request)
{
    $device = CustomerDevice::updateOrCreate(
        ['device_id' => $request->device_id],
        [
            'device_id' => $request->device_id,
            'customer_name' => $request->customer_name ?? 'Unknown',
            'phone_number' => $request->phone_number ?? '0000000000',
            'status' => 'active',
            'lock_type' => 'soft',
            'is_blocked' => false,
            'is_fully_paid' => false,
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'Device registered successfully',
        'device_id' => $device->device_id,
    ]);
}
    // ✅ 2. Check Status
    public function checkStatus($device_id)
    {
        $device = CustomerDevice::where('device_id', $device_id)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'status' => 'active',
                'lock_type' => 'soft',
                'message' => 'Device not found',
                'is_blocked' => false,
                'is_fully_paid' => false,
            ]);
        }

        // Determine status
        if ($device->is_fully_paid) {
            $status = 'cleared';
        } elseif ($device->is_blocked && $device->lock_type == 'full') {
            $status = 'full_lock';
        } elseif ($device->is_blocked) {
            $status = 'soft_block';
        } else {
            $status = 'active';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'lock_type' => $device->lock_type,
            'message' => $device->is_blocked ? 'Installment overdue' : 'Device is active',
            'is_blocked' => $device->is_blocked,
            'is_fully_paid' => $device->is_fully_paid,
        ]);
    }

    // ✅ 3. Receive Location
    public function receiveLocation(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        $device = CustomerDevice::where('device_id', $request->device_id)->first();

        if ($device) {
            $device->update([
                'last_latitude' => $request->latitude,
                'last_longitude' => $request->longitude,
                'last_location_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    // ✅ 4. Admin: Soft Block Device
    public function softBlock(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $device = CustomerDevice::where('device_id', $request->device_id)->first();

        if ($device) {
            $device->update([
                'status' => 'soft_block',
                'lock_type' => 'soft',
                'is_blocked' => true,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Device soft blocked']);
    }

    // ✅ 5. Admin: Full Lock Device
    public function fullLock(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $device = CustomerDevice::where('device_id', $request->device_id)->first();

        if ($device) {
            $device->update([
                'status' => 'full_lock',
                'lock_type' => 'full',
                'is_blocked' => true,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Device fully locked']);
    }

    // ✅ 6. Admin: Unblock Device
    public function unblock(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $device = CustomerDevice::where('device_id', $request->device_id)->first();

        if ($device) {
            $device->update([
                'status' => 'active',
                'lock_type' => 'soft',
                'is_blocked' => false,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Device unblocked']);
    }

    // ✅ 7. Admin: Mark Fully Paid
    public function markFullyPaid(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $device = CustomerDevice::where('device_id', $request->device_id)->first();

        if ($device) {
            $device->update([
                'status' => 'cleared',
                'is_fully_paid' => true,
                'is_blocked' => false,
                'lock_type' => 'soft',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Device marked as fully paid']);
    }

    // ✅ 8. Admin: Get All Devices
    public function getAllDevices()
    {
        $devices = CustomerDevice::all();
        return response()->json([
            'success' => true,
            'devices' => $devices
        ]);
    }
}
