<?php

namespace App\Http\Controllers\Admin\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class PharmacyController extends Controller
{
    //

    //عرض جدول الصيدلية

    public function index()
    {
        $pharmacies = Pharmacy::all();
        return view('Admin.Pharmacy.index', compact('pharmacies'));
    }

    //عرض صفحة اضافة صيدلية

    public function create()
    {

        return view('Admin.Pharmacy.create');
    }

    //تخزين بيانات الصيدلية في قاعدة البيانات

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required|digits:7',
            'city' => 'required|string',
            'address' => 'required|string',
        ]);

        $password = $validatedData['password'];
        $image = $request->file('img')->getClientOriginalName();
        $path = $request->file('img')->storeAs('PharmacyImage', $image, 'image');

        $ifExists = Pharmacy::where('email', $validatedData['email'])->first();
        if ($ifExists) {
            return redirect()->back()->with('error_message', 'Pharmacy Already Exists Write Another Email');
        } else {
            Pharmacy::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($password),
                'status' => $request->input('status'),
                'phone' => $validatedData['phone'],
                'city' => $validatedData['city'],
                'address' => $validatedData['address'],
                'img' => $path,
                'created_by' => Auth::guard('admin')->user()->id,
            ]);

            return redirect()->route('admin.pharmacy.index')->with('success_message', 'Pharmacy Created Successfully');
        }
    }

    //عرض صفحة تعديل صيدلية

    public function edit($pharmacyID)
    {
        $pharmacy = Pharmacy::findOrfail($pharmacyID);
        return view('Admin.Pharmacy.edit', compact('pharmacy'));
    }

    //تعديل بيانات صيدلية في قاعدة البيانات

    public function update(Request $request, $pharmacyID)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|digits:7',
            'city' => 'required|string',
            'address' => 'required|string',
            'img' => 'nullable|file|image',
        ]);

        $pharmacy = Pharmacy::findOrFail($pharmacyID);


        if ($request->hasFile('img')) {
            if ($pharmacy->img) {
                FacadesStorage::disk('image')->delete($pharmacy->img);
            }
            $image = $request->file('img')->getClientOriginalName();
            $path = $request->file('img')->storeAs('PharmacyImage', $image, 'image');
            $validatedData['img'] = $path;
        }


        $pharmacy->update(array_merge($validatedData, [
            'status' => $request->input('status')
        ]));

        return redirect()->route('admin.pharmacy.index')->with('success_message', 'Pharmacy Updated Successfully');
    }

    // حذف صيدلية ونقلها للارشيف

    public function delete($pharmacyID)
    {

        $pharmacy = Pharmacy::findOrFail($pharmacyID);

        $pharmacy->update([ 'status' => 0]);

        $pharmacy->delete();

        return redirect()->back()->with('success_message', 'Pharmacy Deleted Successfully');
    }

    //عرض صفحة جدول الصيدليات المحذوفين

    public function archive()
    {
        $pharmacies = Pharmacy::onlyTrashed()->get();
        return view('Admin.Pharmacy.archive', compact('pharmacies'));
    }

    //حذف الصيدلية بشكل نهائي

    public function forceDelete($pharmacyID)
    {
        $pharmacy = Pharmacy::withTrashed()->where('id', $pharmacyID)->first();
        if ($pharmacy) {
            FacadesStorage::disk('image')->delete($pharmacy->img);
            $pharmacy->forceDelete();

            return redirect()->route('admin.pharmacy.archive')->with('success_message', 'Pharmacy Force Deleted Successfully');
        } else {
            return redirect()->back()->with('error_message', 'Pharmacy Not Found');
        }
    }

    //استعادة الصيدلية المحذوفة من الارشيف

    public function restore($pharmacyID)
    {

        Pharmacy::withTrashed()->where('id', $pharmacyID)->restore();
        $pharmacy = Pharmacy::findOrFail($pharmacyID);

        $pharmacy->update([ 'status' => 1]);


        return redirect()->route('admin.pharmacy.index')->with('success_message', 'Pharmacy Restored Successfully');
    }
}
