<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\EmployeeController;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', [MedicineController::class, 'websiteHome'])->name('/');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


Route::resource('categories', CategoryController::class);


Route::resource('medicines', MedicineController::class);


Route::resource('employees', EmployeeController::class);

Route::get('employees/login', [EmployeeController::class, 'employees_login_page'])->name('employees_login_page');
Route::post('EmployeeLogin', [EmployeeController::class, 'EmployeeLogin'])->name('EmployeeLogin');


require __DIR__.'/auth.php';


