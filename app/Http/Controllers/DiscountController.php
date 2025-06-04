<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DiscountNotification;
use Illuminate\Support\Facades\Notification;

class DiscountController extends Controller
{
    public function index()
    {
        $storehouseId = auth('store_houses')->id();

$discounts = Discount::whereHas('medicine', function ($query) use ($storehouseId) {
    $query->where('store_houses_id', $storehouseId);
})->get();
        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        $medicines = Medicine::where('store_houses_id', Auth::guard('store_houses')->user()->id)->get();
        return view('discounts.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'discounted_price' => 'required|numeric|min:0',
        ]);

        Discount::create([
            'medicine_id' => $request->medicine_id,
            'discounted_price' => $request->discounted_price,
        ]);

        // Send DiscountNotification
        $pharmcies = Pharmacy::all();
        $medicine = Medicine::find($request->medicine_id);
        Notification::send($pharmcies, new DiscountNotification($medicine));
        return redirect()->route('discounts.index')->with('success', 'تم إضافة التخفيض بنجاح');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $medicines = Medicine::where('store_houses_id', Auth::guard('store_houses')->user()->id)->get();
        return view('discounts.edit', compact('discount', 'medicines'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'discounted_price' => 'required|numeric|min:0',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->update([
            'medicine_id' => $request->medicine_id,
            'discounted_price' => $request->discounted_price,
        ]);

        return redirect()->route('discounts.index')->with('success', 'تم تحديث التخفيض بنجاح');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'تم حذف التخفيض بنجاح');
    }

    //
}
