<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\PharmaceuticalCompanies;
 

class MedicineController extends Controller
{
    
    public function index()
    {
        $medicines = Medicine::all();
        return view('medicines.index', compact('medicines'));
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
        $medicine->company_id = $request->company_id; // إضافة الشركة
        $medicine->description = $request->description;
      
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $medicine->image = basename($imagePath); // حفظ اسم الصورة
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
    }
    public function websiteHome(){
        //  get all medi

        // return view('welcome', compact('medicine', 'categories', 'companies'));

    }
}