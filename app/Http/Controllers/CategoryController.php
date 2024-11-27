<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CategoryController;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }


    public function edit($id)
{
    // ابحث عن التصنيف بواسطة الـ ID
    $category = Category::findOrFail($id);

    // أرسل البيانات إلى صفحة التعديل
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
    // تحقق من البيانات المدخلة
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // ابحث عن التصنيف بواسطة الـ ID
    $category = Category::findOrFail($id);

    // حدّث البيانات
    $category->name = $request->input('name');
    $category->save();

    // أعد توجيه المستخدم مع رسالة نجاح
    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}

    public function destroy($id)
{
    // العثور على الفئة باستخدام المعرف (ID)
    $category = Category::find($id);

    // التحقق إذا كانت الفئة موجودة
    if (!$category) {
        return redirect()->route('categories.index')->with('error_message', 'Category not found.');
    }

    // حذف الفئة
    $category->delete();

    // إعادة التوجيه مع رسالة نجاح
    return redirect()->route('categories.index')->with('success_message', 'Category deleted successfully.');
}
}