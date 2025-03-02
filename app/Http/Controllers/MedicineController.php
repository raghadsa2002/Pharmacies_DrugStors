<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\StoreHouse;
use App\Models\PharmaceuticalCompanies;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    public function homePage()
    {
        $medicines = Medicine::with('company', 'category')->get();
        return view('website.Homepage', compact('medicines'));
    }

    public function index()
    {
        // إضافة فلترة الأدوية حسب المستودع الذي يخص المستخدم الحالي
        $medicines = Medicine::where('store_houses_id', Auth::guard('store_houses')->user()->id)->get();
        
        // إضافة رابط الصورة بشكل صحيح لكل دواء
        foreach ($medicines as $medicine) {
            if ($medicine->image) {
                $medicine->image_url = asset('storage/images/' . $medicine->image); // رابط الصورة
            }
        }
        
        return view('medicines.index', compact('medicines'));
    }

    public function products(Request $request)
    {
        $companies = PharmaceuticalCompanies::all();
        $categories = Category::all();
        $storehouses = \App\Models\StoreHouse::all(); // جلب المستودعات
    
        // فلترة الأدوية حسب الشركة والفئة والمستودع
        $medicines = Medicine::with('company', 'category', 'storehouse');
    
        // تطبيق الفلاتر فقط لو تم اختيار قيمة
        if ($request->filled('company_id')) {
            $medicines = $medicines->where('company_id', $request->company_id);
        }
    
        if ($request->filled('category_id')) {
            $medicines = $medicines->where('category_id', $request->category_id);
        }
    
        if ($request->filled('storehouse_id')) {
            $medicines = $medicines->where('store_houses_id', $request->storehouse_id);
        }
    
        $medicines = $medicines->get();
    
        return view('website.products', compact('medicines', 'companies', 'categories', 'storehouses'));
    }
    public function create()
    {
        $categories = \App\Models\Category::all();
        $companies = \App\Models\PharmaceuticalCompanies::all();
        return view('medicines.create', compact('categories', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:pharmaceutical_companies,id',
        ]);

        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->price = $request->price;
        $medicine->stock = $request->stock;
        $medicine->status = $request->status;
        $medicine->category_id = $request->category_id;
        $medicine->company_id = $request->company_id;
        $medicine->description = $request->description;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension(); // اسم فريد للصورة
            $request->file('image')->move(public_path('DashboardAssets/images'), $imageName); // حفظ الصورة داخل مجلد public/images
            $medicine->image = $imageName; // حفظ اسم الصورة في قاعدة البيانات
        }

        // تحديد المستودع عند إضافة الدواء
        if (Auth::guard('store_houses')->check()) {
            $medicine->store_houses_id = Auth::guard('store_houses')->user()->id;
        }

        $medicine->save();

        return redirect()->route('medicines.index')->with('success', 'Medicine added successfully');
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        $categories = Category::all();
        $companies = PharmaceuticalCompanies::all();

        return view('medicines.edit', compact('medicine', 'categories', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:pharmaceutical_companies,id',
        ]);
        $medicine = Medicine::findOrFail($id);
        $medicine->name = $request->name;
        $medicine->price = $request->price;
        $medicine->stock = $request->stock;
        $medicine->status = $request->status;
        $medicine->category_id = $request->category_id;
        $medicine->company_id = $request->company_id;
        $medicine->description = $request->description;

        // إضافة صورة جديدة للدواء إذا كانت موجودة
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension(); // اسم فريد للصورة
            $request->file('image')->move(public_path('DashboardAssets/images'), $imageName); // حفظ الصورة داخل مجلد public/images
            $medicine->image = $imageName; // تحديث اسم الصورة في قاعدة البيانات
        }

        $medicine->save();

        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully');
    }

    public function websiteHome()
    {
        // Get all medicines for the website's homepage
        $medicines = Medicine::with('company', 'category')->get();
        return view('website.Homepage', compact('medicines'));
    }
}