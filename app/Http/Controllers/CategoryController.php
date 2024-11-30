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
   
    $category = Category::findOrFail($id);

    
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
   
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    
    $category = Category::findOrFail($id);

   
    $category->name = $request->input('name');
    $category->save();

  
    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
}

    public function destroy($id)
{
    
    $category = Category::find($id);

    
    if (!$category) {
        return redirect()->route('categories.index')->with('error_message', 'Category not found.');
    }

   
    $category->delete();

  
    return redirect()->route('categories.index')->with('success_message', 'Category deleted successfully.');
}
}