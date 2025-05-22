<?php

namespace App\Http\Controllers\Admin\StoreHouse;

use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Models\StoreHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreHouseController extends Controller
{
    //

    //عرض جدول المستودعات

    public function index()
    {
        $storeHouses = StoreHouse::all();
        return view('Admin.StoreHouse.index', compact('storeHouses'));
    }

    //عرض صفحة اضافة مستودع

    public function create()
    {

        return view('Admin.StoreHouse.create');
    }

    //تخزين بيانات المستودع في قاعدة البيانات

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'phone' => 'required|digits:10',
        'city' => 'required|string',
        'address' => 'required|string',
        'status' => 'required',
        'email' => 'required|email|unique:store_houses,email', // التحقق من صحة الإيميل وتفرده
        'password' => 'required|string|min:8', // التحقق من كلمة المرور
    ]);

    $ifExists = StoreHouse::where('name', $validatedData['name'])->first();
    if ($ifExists) {
        return redirect()->back()->with('error_message', 'Store House Already Exists Write Another Name');
    } else {
        StoreHouse::create([
            'name' => $validatedData['name'],
            'status' => $request->input('status'),
            'phone' => $validatedData['phone'],
            'city' => $validatedData['city'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'], // إضافة الإيميل
            'password' => bcrypt($validatedData['password']), // تخزين كلمة المرور بعد التشفير
            'created_by' => Auth::guard('admin')->user()->id,
        ]);

        return redirect()->route('admin.storeHouse.index')->with('success_message', 'Store House Created Successfully');
    }
}

    //عرض صفحة تعديل مستودع

    public function edit($storeHouseID)
    {
        $storeHouse = StoreHouse::findOrfail($storeHouseID);
        return view('Admin.StoreHouse.edit', compact('storeHouse'));
    }

    //تعديل بيانات مستودع في قاعدة البيانات

    public function update(Request $request, $storeHouseID)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'phone' => 'required|digits:10',
        'city' => 'required|string',
        'address' => 'required|string',
        'status' => 'required',
        'email' => 'required|email|unique:store_houses,email,' . $storeHouseID,
        'password' => 'nullable|string|min:8',
    ]);

    $storeHouse = StoreHouse::findOrFail($storeHouseID);

    $updateData = [
        'name' => $validatedData['name'],
        'status' => $request->input('status'),
        'phone' => $validatedData['phone'],
        'city' => $validatedData['city'],
        'address' => $validatedData['address'],
        'email' => $validatedData['email'],
        'created_by' => Auth::guard('admin')->user()->id,
    ];

    // تحديث كلمة السر فقط إذا تم إدخالها
    if (!empty($validatedData['password'])) {
        $updateData['password'] = bcrypt($validatedData['password']);
    }

    $storeHouse->update($updateData);

    return redirect()->route('admin.storeHouse.index')->with('success_message', 'Store House Updated Successfully');
}

    //حذف مستودع ونقله للارشيف

    public function delete($storeHouseID)
    {

        $storeHouse = StoreHouse::findOrFail($storeHouseID);

        if ($storeHouse) {

            $storeHouse->delete();

            return redirect()->back()->with('success_message', 'Store House Deleted Successfully');
        }
        return redirect()->back()->with('success_message', 'Store House Not Found');
    }

    //عرض صفحة جدول المستودعات المحذوفة

    public function archive()
    {
        $storeHouses = StoreHouse::onlyTrashed()->get();
        return view('Admin.StoreHouse.archive', compact('storeHouses'));
    }

    //حذف المستودع بشكل نهائي

    public function forceDelete($storeHouseID)
    {
        $storeHouse = StoreHouse::withTrashed()->where('id', $storeHouseID)->first();
        if ($storeHouse) {

            $storeHouse->forceDelete();

            return redirect()->route('admin.storeHouse.archive')->with('success_message', 'Store House Force Deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'Store House Not Found');
        }
    }

    //استعادة المستودعات المحذوفة من الارشيف

    public function restore($storeHouseID)
    {
        StoreHouse::withTrashed()->where('id', $storeHouseID)->restore();

        return redirect()->route('admin.storeHouse.index')->with('success_message', 'Store House Restored Successfully');
    }

    public function showReviews()
    {
        $reviews = Review::with('pharmacy')->get();
        return view('admin.storeHouse.review', compact('reviews'));
    }

}
