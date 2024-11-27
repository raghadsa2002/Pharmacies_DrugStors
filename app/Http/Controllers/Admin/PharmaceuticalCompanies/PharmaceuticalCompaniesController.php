<?php

namespace App\Http\Controllers\Admin\PharmaceuticalCompanies;

use App\Http\Controllers\Controller;
use App\Models\PharmaceuticalCompanies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmaceuticalCompaniesController extends Controller
{
    //

    //عرض جدول شركات الادوية

    public function index()
    {
        $pharmaceuticalCompanies = PharmaceuticalCompanies::all();
        return view('Admin.PharmaceuticalCompanies.index', compact('pharmaceuticalCompanies'));
    }

    //عرض صفحة اضافة شركة ادوية

    public function create()
    {

        return view('Admin.PharmaceuticalCompanies.create');
    }

    //تخزين بيانات شركات الادوية في قاعدة البيانات

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|digits:10',
            'city' => 'required|string',
            'address' => 'required|string',
            'status' => 'required',
        ]);


        $ifExists = PharmaceuticalCompanies::where('name', $validatedData['name'])->first();
        if ($ifExists) {
            return redirect()->back()->with('error_message', 'Pharmaceutical Companies Already Exists Write Another Name');
        } else {
            PharmaceuticalCompanies::create([
                'name' => $validatedData['name'],
                'status' => $request->input('status'),
                'phone' => $validatedData['phone'],
                'city' => $validatedData['city'],
                'address' => $validatedData['address'],
                'created_by' => Auth::guard('admin')->user()->id,
            ]);

            return redirect()->route('admin.pharmaceuticalCompanies.index')->with('success_message', 'Pharmaceutical Companies Created Successfully');
        }
    }

    //عرض صفحة تعديل شركات الادوية

    public function edit($pharmaceuticalCompaniesID)
    {
        $pharmaceuticalCompany = PharmaceuticalCompanies::findOrfail($pharmaceuticalCompaniesID);
        return view('Admin.PharmaceuticalCompanies.edit', compact('pharmaceuticalCompany'));
    }

    //تعديل بيانات شركة ادوية في قاعدة البيانات

    public function update(Request $request, $pharmaceuticalCompaniesID)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|digits:10',
            'city' => 'required|string',
            'address' => 'required|string',
            'status' => 'required',
        ]);

        $pharmaceuticalCompany = PharmaceuticalCompanies::findOrFail($pharmaceuticalCompaniesID);

        $pharmaceuticalCompany->update([

            'name' => $validatedData['name'],
            'status' => $request->input('status'),
            'phone' => $validatedData['phone'],
            'city' => $validatedData['city'],
            'address' => $validatedData['address'],
            'created_by' => Auth::guard('admin')->user()->id,
        ]);


        return redirect()->route('admin.pharmaceuticalCompanies.index')->with('success_message', 'Pharmaceutical Companies Updated Successfully');
    }

    //حذف شركة ادوية ونقلها للارشيف

    public function delete($pharmaceuticalCompaniesID)
    {

        $pharmaceuticalCompany = PharmaceuticalCompanies::findOrFail($pharmaceuticalCompaniesID);

        if ($pharmaceuticalCompany) {

            $pharmaceuticalCompany->delete();

            return redirect()->back()->with('success_message', 'Pharmaceutical Companies Deleted Successfully');
        }
        return redirect()->back()->with('success_message', 'Pharmaceutical Companies Not Found');
    }

    //عرض صفحة جدول شركات الادوية المحذوفة

    public function archive()
    {
        $pharmaceuticalCompanies = PharmaceuticalCompanies::onlyTrashed()->get();
        return view('Admin.PharmaceuticalCompanies.archive', compact('pharmaceuticalCompanies'));
    }

    //حذف شركة الادوية بشكل نهائي

    public function forceDelete($pharmaceuticalCompaniesID)
    {
        $pharmaceuticalCompany = PharmaceuticalCompanies::withTrashed()->where('id', $pharmaceuticalCompaniesID)->first();
        if ($pharmaceuticalCompany) {

            $pharmaceuticalCompany->forceDelete();

            return redirect()->route('admin.pharmaceuticalCompanies.archive')->with('success_message', 'Pharmaceutical Companies Force Deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'Pharmaceutical Companies Not Found');
        }
    }

    //استعادة شركات الادوية المحذوفة من الارشيف

    public function restore($pharmaceuticalCompaniesID)
    {
        PharmaceuticalCompanies::withTrashed()->where('id', $pharmaceuticalCompaniesID)->restore();

        return redirect()->route('admin.pharmaceuticalCompanies.index')->with('success_message', 'Pharmaceutical Companies Restored Successfully');
    }
}
