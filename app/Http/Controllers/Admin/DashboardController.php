<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerDevice;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    // Show dashboard with approved shops
    public function index()
    {
        $shops = Shop::where('is_approved', true)->get();
        return view('admin.dashboard', compact('shops'));
    }

    // Show pending shop requests
    public function pendingRequests()
    {
        $pendingShops = Shop::where('is_approved', false)->get();
        return view('admin.pending_requests', compact('pendingShops'));
    }

    // Approve shop
    public function approveShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Shop approved successfully');
    }

    // Reject shop (delete)
    public function rejectShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return redirect()->back()->with('success', 'Shop rejected and deleted');
    }

    // Delete shop owner and all their devices
    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);

        // Delete all devices of this shop
        CustomerDevice::where('shop_id', $id)->delete();

        // Delete the shop
        $shop->delete();

        return redirect()->back()->with('success', 'Shop and all devices deleted successfully');
    }
}
