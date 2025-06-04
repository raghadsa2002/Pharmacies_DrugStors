<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use App\Models\Pharmacy;
use App\Notifications\NewOfferNotification;

class OfferController extends Controller
{
 public function index()
{
    $storehouseId = Auth::guard('store_houses')->id();

    $offers = Offer::where('store_houses_id', $storehouseId)
        ->with('items.medicine')
        ->latest()
        ->paginate(10); // Pagination هنا

    return view('offers.index', compact('offers'));
}

    public function create()
    {
        $storehouseId = Auth::guard('store_houses')->id();
        $medicines = Medicine::where('store_houses_id', $storehouseId)->get();
        return view('offers.create', compact('medicines'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'items' => 'required|array|min:1',
        'items.*.medicine_id' => 'required|exists:medicines,id',
        'items.*.type' => 'required|in:discount,free',
        'items.*.required_quantity' => 'required|integer|min:1',
    ]);

    // تحقق مخصص للقيمة فقط إذا كانت type = discount
    foreach ($request->items as $index => $item) {
        if ($item['type'] !== 'free' && (!isset($item['value']) || $item['value'] === null)) {
            return back()->withErrors([
                "items.$index.value" => 'The value field is required when type is discount.',
            ])->withInput();
        }
    }

    $storeHouseUser = auth('store_houses')->user();

    $offer = Offer::create([
        'title' => $request->title,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'store_houses_id' => $storeHouseUser->id,
    ]);

 

// إرسال إشعار لكل الصيدليات
$pharmacies = Pharmacy::all();
foreach ($pharmacies as $pharmacy) {
    $pharmacy->notify(new NewOfferNotification($request->title));
}

    foreach ($request->items as $item) {
        $offer->items()->create([
            'medicine_id' => $item['medicine_id'],
            'type' => $item['type'],
            'value' => $item['type'] === 'free' ? 0 : $item['value'], // هنا تتأكدين إن القيمة 0 لو مجاني
            'required_quantity' => $item['required_quantity'],
        ]);
    }

    return redirect()->route('offers.index')->with('success', 'Offer created successfully!');
}

public function edit($id)
{
    $storehouseId = auth('store_houses')->id();

    $offer = Offer::where('store_houses_id', $storehouseId)
        ->with('items')
        ->findOrFail($id);

    $medicines = Medicine::where('store_houses_id', $storehouseId)->get();

    return view('offers.edit', compact('offer', 'medicines'));
}

public function update(Request $request, $id)
{
    $storehouseId = auth('store_houses')->id();

    // validation الأساسي
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'items' => 'required|array|min:1',
        'items.*.medicine_id' => 'required|exists:medicines,id',
        'items.*.type' => 'required|in:discount,free',
        'items.*.value' => 'nullable|numeric|min:0',
        'items.*.required_quantity' => 'required|integer|min:1',
    ]);

    // تحقق مخصص بعد الفاليديشن
    foreach ($request->items as $index => $item) {
        if ($item['type'] !== 'free' && (!isset($item['value']) || $item['value'] === null)) {
            return back()->withErrors([
                "items.$index.value" => 'The value field is required when type is discount.',
            ])->withInput();
        }
    }

    $offer = Offer::where('store_houses_id', $storehouseId)->findOrFail($id);

    // تحديث بيانات العرض الأساسي
    $offer->update([
        'title' => $request->title,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    // حذف العناصر المحددة (IDs محذوفة)
    if ($request->filled('deleted_items')) {
        $deletedIds = explode(',', $request->deleted_items);
        OfferItem::whereIn('id', $deletedIds)->delete();
    }

    // معالجة العناصر: تحديث الموجودين وإضافة الجدد
    foreach ($request->items as $itemData) {
        if (isset($itemData['id'])) {
            // تحديث عنصر موجود
            $item = OfferItem::find($itemData['id']);
            if ($item && $item->offer_id == $offer->id) {
                $item->update([
                    'medicine_id' => $itemData['medicine_id'],
                    'type' => $itemData['type'],
                    'value' => $itemData['type'] === 'free' ? 0 : $itemData['value'], // لو free خلي القيمة 0
                    'required_quantity' => $itemData['required_quantity'],
                ]);
            }
        } else {
            // إضافة عنصر جديد
            $offer->items()->create([
                'medicine_id' => $itemData['medicine_id'],
                'type' => $itemData['type'],
                'value' => $itemData['type'] === 'free' ? 0 : $itemData['value'], // لو free خلي القيمة 0
                'required_quantity' => $itemData['required_quantity'],
            ]);
        }
    }

    return redirect()->route('offers.index')->with('success', 'Offer updated successfully!');
}
    public function destroy($id)
    {
        $storehouseId = Auth::guard('store_houses')->id();
        $offer = Offer::where('store_houses_id', $storehouseId)->findOrFail($id);
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully.');
    }


    
}