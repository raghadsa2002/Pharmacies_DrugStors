<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\PharmaceuticalCompanies;
use App\Models\Pharmacy;
use App\Models\StoreHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    //عرض الصفحة الرئيسية للادمن

    public function index()
    {
        $adminLogged = Auth::guard('admin')->user();
        $adminName = $adminLogged->name;
        $adminCount = Admin::all()->count();
        $pharmacyCount = Pharmacy::all()->count();
        $storeHouseCount = StoreHouse::all()->count();
        $pharmaceuticalCompaniesCount = PharmaceuticalCompanies::all()->count();

        return view('Admin.dashboard' , compact('adminName' , 'adminCount' , 'pharmacyCount' ,'storeHouseCount' ,'pharmaceuticalCompaniesCount'));
    }
}
