<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\PharmaceuticalCompanies\PharmaceuticalCompaniesController;
use App\Http\Controllers\Admin\Pharmacy\PharmacyController;
use App\Http\Controllers\Admin\StoreHouse\StoreHouseController;
use Illuminate\Support\Facades\Route;





//============================ Admin Route ==========================

//============= I write Prefix (admin) And name(admin.) in bootsrap/app.php

//============================ Auth Route ==========================

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/login/check', [AuthController::class, 'checkLogin'])->name('check.login');

Route::middleware('Admin')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AdminController::class, 'index'])->name('index');

    //========================== Pharmacy Manage Route =========================

    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {

        Route::get('/index', [PharmacyController::class, 'index'])->name('index');

        Route::get('/create', [PharmacyController::class, 'create'])->name('create');

        Route::post('/store', [PharmacyController::class, 'store'])->name('store');

        Route::get('/edit/{pharmacyID}', [PharmacyController::class, 'edit'])->name('edit');

        Route::put('/update/{pharmacyID}', [PharmacyController::class, 'update'])->name('update');

        Route::delete('/delete/{pharmacyID}', [PharmacyController::class, 'delete'])->name('delete');

        Route::get('/archive', [PharmacyController::class, 'archive'])->name('archive');

        Route::delete('/forceDelete/{pharmacyID}', [PharmacyController::class, 'forceDelete'])->name('force.delete');

        Route::get('/restore/{pharmacyID}', [PharmacyController::class, 'restore'])->name('restore');
    });

    //========================== Store House Manage Route =========================

    Route::prefix('storeHouse')->name('storeHouse.')->group(function () {

        Route::get('/index', [StoreHouseController::class, 'index'])->name('index');

        Route::get('/create', [StoreHouseController::class, 'create'])->name('create');

        Route::post('/store', [StoreHouseController::class, 'store'])->name('store');

        Route::get('/edit/{storeHouseID}', [StoreHouseController::class, 'edit'])->name('edit');

        Route::put('/update/{storeHouseID}', [StoreHouseController::class, 'update'])->name('update');

        Route::delete('/delete/{storeHouseID}', [StoreHouseController::class, 'delete'])->name('delete');

        Route::get('/archive', [StoreHouseController::class, 'archive'])->name('archive');

        Route::delete('/forceDelete/{storeHouseID}', [StoreHouseController::class, 'forceDelete'])->name('force.delete');

        Route::get('/restore/{storeHouseID}', [StoreHouseController::class, 'restore'])->name('restore');
    });

    //========================== Pharmaceutical Companies Manage Route =========================

    Route::prefix('pharmaceuticalCompanies')->name('pharmaceuticalCompanies.')->group(function () {

        Route::get('/index', [PharmaceuticalCompaniesController::class, 'index'])->name('index');

        Route::get('/create', [PharmaceuticalCompaniesController::class, 'create'])->name('create');

        Route::post('/store', [PharmaceuticalCompaniesController::class, 'store'])->name('store');

        Route::get('/edit/{pharmaceuticalCompaniesID}', [PharmaceuticalCompaniesController::class, 'edit'])->name('edit');

        Route::put('/update/{pharmaceuticalCompaniesID}', [PharmaceuticalCompaniesController::class, 'update'])->name('update');

        Route::delete('/delete/{pharmaceuticalCompaniesID}', [PharmaceuticalCompaniesController::class, 'delete'])->name('delete');

        Route::get('/archive', [PharmaceuticalCompaniesController::class, 'archive'])->name('archive');

        Route::delete('/forceDelete/{pharmaceuticalCompaniesID}', [PharmaceuticalCompaniesController::class, 'forceDelete'])->name('force.delete');

        Route::get('/restore/{pharmaceuticalCompaniesID}', [PharmaceuticalCompaniesController::class, 'restore'])->name('restore');
    });
});
