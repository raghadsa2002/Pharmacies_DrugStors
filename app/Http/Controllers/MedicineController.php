<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Employee;
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
        $store_id = null;
        if(Auth::guard('employees')->user()) {
            
            $employee = Employee::findOrFail(Auth::guard('store_houses')->user()->id);
            $store_id = $employee->storehouse_id; // 
        } // عرض الادوية لموظف المستوجع
        else
            $store_id = Auth::guard('store_houses')->user()->id; // عرض الادوية لمدير المستوجع

        // return var_dump('$store_id ' . $store_id);
        $medicines = Medicine::where('store_houses_id',$store_id)->get();
        // return dd($medicines);
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
        $storehouses = StoreHouse::all(); // جلب المستودعات
    
        // نبدأ استعلام الأدوية
        $medicines = Medicine::query()->with('company', 'category', 'storehouse');
    
        // تطبيق الفلاتر فقط لو المستخدم اختار قيمة
        if ($request->filled('company_id')) {
            $medicines->where('company_id', $request->company_id);
        }
    
        if ($request->filled('category_id')) {
            $medicines->where('category_id', $request->category_id);
        }
    
        if ($request->filled('storehouse_id')) {
            $medicines->where('store_houses_id', $request->storehouse_id);
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
    
        // التحقق من المستخدم وإسناد storehouse_id بشكل صحيح
        if (Auth::guard('employees')->check()) {
            $employee = Auth::guard('employees')->user();
            $medicine->store_houses_id = $employee->storehouse_id; // المستودع المرتبط بالموظف
        } elseif (Auth::guard('store_houses')->check()) {
            $storehouse = Auth::guard('store_houses')->user();
            $medicine->store_houses_id = $storehouse->id; // id هنا هو المستودع نفسه
        } else {
            return redirect()->back()->withErrors(['error' => 'Unauthorized access']);
        }
    
        // رفع الصورة إن وجدت
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('DashboardAssets/images'), $imageName);
            $medicine->image = $imageName;
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
        $medicines = Medicine::with('company', 'category','store_house')->get();
        return view('website.Homepage', compact('medicines'));

    }
}