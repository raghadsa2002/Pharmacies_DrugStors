<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OfferController extends Controller
{
    // عرض كل العروض للمستودع المسجل دخول
    public function index()
    {
        $storeHouseId = Auth::guard('store_houses')->user()->id;
        $offers = Offer::where('store_houses_id', $storeHouseId)
                        ->with(['medicine1', 'medicine2'])
                        ->latest()
                        ->get();

        return view('offers.index', compact('offers'));
    }

    // عرض نموذج إضافة عرض جديد
    public function create()
    {
        $storeHouseId = Auth::guard('store_houses')->user()->id;
        $medicines = Medicine::where('store_houses_id', $storeHouseId)->get();

        return view('offers.create', compact('medicines'));
    }

    // تخزين العرض الجديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'medicine_id_1' => 'required|exists:medicines,id|different:medicine_id_2',
            'medicine_id_2' => 'required|exists:medicines,id|different:medicine_id_1',
            'discount_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $storeHouseId = Auth::guard('store_houses')->user()->id;

        try {
            Offer::create([
                'title' => $request->title,
                'store_houses_id' => $storeHouseId,
                'medicine_id_1' => $request->medicine_id_1,
                'medicine_id_2' => $request->medicine_id_2,
                'discount_price' => $request->discount_price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('offers.index')->with('success', 'تم إضافة العرض بنجاح.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء إضافة العرض: ' . $e->getMessage());
        }
    }

    // عرض نموذج تعديل عرض
    public function edit($id)
    {
        $storeHouseId = Auth::guard('store_houses')->user()->id;
        $offer = Offer::where('store_houses_id', $storeHouseId)->findOrFail($id);
        $medicines = Medicine::where('store_houses_id', $storeHouseId)->get();

        return view('offers.edit', compact('offer', 'medicines'));
    }

    // تحديث العرض
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'medicine_id_1' => 'required|exists:medicines,id|different:medicine_id_2',
            'medicine_id_2' => 'required|exists:medicines,id|different:medicine_id_1',
            'discount_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $storeHouseId = Auth::guard('store_houses')->user()->id;
        $offer = Offer::where('store_houses_id', $storeHouseId)->findOrFail($id);

        $offer->update([
            'title' => $request->title,
            'medicine_id_1' => $request->medicine_id_1,
            'medicine_id_2' => $request->medicine_id_2,
            'discount_price' => $request->discount_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('offers.index')->with('success', 'تم تعديل العرض بنجاح.');
    }

    // حذف العرض
    public function destroy($id)
    {
        $storeHouseId = Auth::guard('store_houses')->user()->id;
        $offer = Offer::where('store_houses_id', $storeHouseId)->findOrFail($id);
        $offer->delete();

        return redirect()->route('offers.index')->with('success', 'تم حذف العرض بنجاح.');
    }
}