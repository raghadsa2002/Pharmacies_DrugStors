<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
 use App\Notifications\LowStockNotification;  
use Illuminate\Support\Facades\Notification;

class StockManagementController extends Controller
{
    public function index()
    {
        // جلب أدوية المستودع الحالي فقط
        $storeHouseId = Auth::guard('store_houses')->id(); // تأكدي من اسم الـ guard
        $medicines = Medicine::where('store_houses_id', $storeHouseId)->get();

        return view('stock.index', compact('medicines'));
    }

public function updateStock(Request $request, $id)
{
    $request->validate([
        'type' => 'required|in:increase,decrease',
        'quantity' => 'required|integer|min:1',
    ]);

    $medicine = Medicine::findOrFail($id);
    $originalStock = $medicine->stock;

    if ($request->type === 'increase') {
        $medicine->stock += $request->quantity;
    } elseif ($request->type === 'decrease') {
        if ($medicine->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock to decrease.');
        }
        $medicine->stock -= $request->quantity;
    }

    $medicine->save();

    // تخزين حركة المخزون
    StockMovement::create([
        'medicine_id' => $medicine->id,
        'type' => $request->type,
        'quantity' => $request->quantity,
        'previous_stock' => $originalStock,
        'new_stock' => $medicine->stock,
    ]);

    // هنا نضيف إشعار انخفاض المخزون
    if ($medicine->stock < $medicine->min_stock) {
        // نجيب المستخدم المسؤول (مدير المستودع)
        $storeHouseUser = auth('store_houses')->user();

        if ($storeHouseUser) {
            $storeHouseUser->notify(new LowStockNotification($medicine));
        }
    }

    return redirect()->back()->with('success', 'Stock updated successfully.');
}
}