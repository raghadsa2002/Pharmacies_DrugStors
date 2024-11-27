<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Category;

class MedicineController extends Controller
{
    // عرض جميع الأدوية
    public function index()
    {
        $medicines = Medicine::all();
        return view('medicines.index', compact('medicines'));
    }

    // عرض صفحة إضافة دواء جديد
    public function create()
    {
        $categories = \App\Models\Category::all(); // جلب جميع الفئات
        return view('medicines.create', compact('categories'));
    }

    // إضافة دواء جديد
    // app/Http/Controllers/MedicineController.php

public function store(Request $request)
{
    // التحقق من البيانات المدخلة
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'status' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    // حفظ الدواء
    $medicine = new Medicine();
    $medicine->name = $request->name;
    $medicine->price = $request->price;
    $medicine->stock = $request->stock;
    $medicine->status = $request->status;
    $medicine->category_id = $request->category_id;
    $medicine->description = $request->description;
    $medicine->manufacturer = $request->manufacturer;

    // التعامل مع الصورة (إذا تم تحميلها)
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('public/images');
        $medicine->image = basename($imagePath); // حفظ اسم الصورة
    }

    $medicine->save();

    // إعادة التوجيه إلى صفحة الـ Index
    return redirect()->route('medicines.index')->with('success', 'Medicine added successfully');
}
   // app/Http/Controllers/MedicineController.php

public function edit($id)
{
    $medicine = Medicine::findOrFail($id);
    $categories = Category::all(); // إذا كنت بحاجة لإظهار قائمة الفئات في الصفحة
    return view('medicines.edit', compact('medicine', 'categories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'status' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    $medicine = Medicine::findOrFail($id);
    $medicine->name = $request->name;
    $medicine->price = $request->price;
    $medicine->stock = $request->stock;
    $medicine->status = $request->status;
    $medicine->category_id = $request->category_id;
    $medicine->description = $request->description;
    $medicine->manufacturer = $request->manufacturer;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('public/images');
        $medicine->image = basename($imagePath);
    }

    $medicine->save();
    
    return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully');
}

public function destroy($id)
{
    $medicine = Medicine::findOrFail($id);
    $medicine->delete();

    return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully');
}}