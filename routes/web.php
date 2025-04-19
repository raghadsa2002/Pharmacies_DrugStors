<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\EmployeeController;
use App\Models\Category;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PharmacistOfferController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});


Route::get('homePage', [MedicineController::class, 'homePage'])->name('homePage');
Route::get('products', [MedicineController::class, 'products'])->name('products');
Route::get('/products/filter', [MedicineController::class, 'filter'])->name('products.filter');


Route::get('/products1', [MedicineController::class, 'products'])->name('medicines.products');
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

Route::resource('offers', OfferController::class);
use App\Http\Controllers\DiscountController;

Route::middleware(['auth:store_houses'])->group(function () {
    Route::resource('discounts', DiscountController::class);
});

// صفحة العروض الخاصة بالصيدلي


Route::get('/orders/pharmacy-offers', [PharmacistOfferController::class, 'index'])->name('orders.pharmacyOffers');
//Route::post('/offers/order/{offerId}', [PharmacistOfferController::class, 'order'])->name('offers.order');
Route::post('/offers/{offer}/order', [OrderController::class, 'createOrder'])->name('offers.order');
// Route::middleware(['auth:pharmacy'])->group(function () {
//     Route::get('/pharmacy/offers', [PharmacistOfferController::class, 'index'])->name('pharmacist.offers.index');
//     Route::post('/pharmacy/offers/{offer}/order', [PharmacistOfferController::class, 'order'])->name('pharmacist.offers.order');







Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

Route::post('orders/store', [OrderController::class, 'store'])->name('orders.store');


Route::post('orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


Route::get('/pharmacy/orders', [OrderController::class, 'pharmacyOrders'])->name('pharmacy.orders');


Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');
require __DIR__.'/auth.php';


