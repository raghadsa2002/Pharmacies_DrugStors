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
use App\Http\Controllers\Admin\StoreHouse\StoreHouseController;
use App\Http\Controllers\StockManagementController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StorehouseReportsController;
use App\Http\Controllers\MessagesController;


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


use App\Http\Controllers\DiscountController;

Route::middleware(['auth:store_houses'])->group(function () {
    Route::resource('discounts', DiscountController::class);
});

// صفحة العروض الخاصة بالصيدلي


// Route::get('/orders/pharmacy-offers', [PharmacistOfferController::class, 'index'])->name('orders.pharmacyOffers');

// Route::post('/offers/{offer}/order', [OrderController::class, 'createOrder'])->name('offers.order');



Route::resource('offers', OfferController::class);
Route::get('/pharmacy/offers', [PharmacistOfferController::class, 'index'])->name('pharmacy.offers');
Route::post('/offers/order/{offer}', [OrderController::class, 'orderOffer'])->name('orders.offer');
Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');


Route::get('/stock', [StockManagementController::class, 'index'])->name('stock.index');

// تحديث الكمية
Route::put('/stock/update/{id}', [StockManagementController::class, 'updateStock'])->name('stock.update');

// موافقة على الطلب
Route::put('/order/approve/{id}', [OrderController::class, 'approveOrder'])->name('order.approve');






Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');



Route::post('orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


Route::get('/pharmacy/orders', [OrderController::class, 'pharmacyOrders'])->name('pharmacy.orders');

Route::post('/pharmacy/orders/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');


Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews');

Route::get('/storHouse/reviews', [StoreHouseController::class, 'showReviews'])->name('storHouse.reviews');


Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');
require __DIR__.'/auth.php';

Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

//التقارير
use App\Http\Controllers\ReportController;


Route::prefix('pharmacy/reports')->middleware('auth:pharmacy')->group(function () {
   
    Route::get('/', [ReportController::class, 'pharmacyReports'])->name('reports.pharmacy.index');
   
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    
    Route::get('/tickets/ticketsMessages/{id}', [TicketController::class, 'getMessages'])->name('tickets.openchat');
    Route::get('/tickets/closechat/{id}', [TicketController::class, 'closeTicket'])->name('tickets.closechat');
    
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::get('/pharmacy/mytickets', [TicketController::class, 'index'])->name('pharmacy.tickets.index');
    Route::post('/pharmacy/tickets', [TicketController::class, 'store'])->name('tickets.store');
});




Route::get('/storehouse/mytickets', [TicketController::class, 'storehouseTickets'])->name('storehouse.tickets');



    Route::get('/tickets', [TicketController::class, 'index'])->name('pharmacy.tickets.index');
Route::get('/pharmacy/mytickets', [TicketController::class, 'index'])
    ->middleware('auth:pharmacy') // إذا عندك حارس (guard) للصيدليات
    ->name('pharmacy.tickets.mytickets');
 

Route::put('/tickets/{id}/close', [TicketController::class, 'closeTicket'])->name('tickets.close');

Route::get('/storehouse/tickets/{id}/chat', [TicketController::class, 'getMessages'])->name('storehouse.tickets.chat');

Route::post('/storehouse/tickets/{id}/send', [StorehouseTicketController::class, 'sendMessage'])->name('storehouse.tickets.sendMessage');
Route::get('/tickets/chat/{ticket}', [MessageController::class, 'showChat'])->name('tickets.chat');
Route::post('/tickets/chat/{ticket}', [MessageController::class, 'sendMessage'])->name('tickets.send');


Route::get('/pharmacy/chat/{ticket_id}', [MessageController::class, 'showChat']);
Route::post('/chat/{ticket}', [MessageController::class, 'store'])->name('chat.store');
Route::get('/pharmacy/chat/{ticket_id}', [MessageController::class, 'showChat'])->name('chat.show');

Route::get('/chat/{ticketId}', [MessageController::class, 'showChat'])->name('tickets.chat');

Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('message.send');
 

Route::get('/tickets/{id}/chat', [TicketController::class, 'getMessages'])->name('tickets.chat');
 Route::middleware(['auth:store_houses'])->prefix('storehouse')->group(function () {
    Route::get('/reports', [StorehouseReportsController::class, 'index'])->name('storehouse.reports');
});
 
Route::middleware(['auth:store_houses'])->prefix('storehouse')->group(function () {
    Route::get('/reports', [StorehouseReportsController::class, 'index'])->name('storehouse.reports');
});



// السلة




// Route::get('/products', [OrderController::class, 'products'])->name('products.index');
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');
Route::post('/cart/store', [OrderController::class, 'storeCart'])->name('cart.store');
Route::get('/pharmacy-orders', [OrderController::class, 'pharmacyOrders'])->name('orders.pharmacyOrders');
Route::get('/pharmacy/orders', [OrderController::class, 'pharmacyOrders'])->name('pharmacy.orders');

Route::post('/checkout', [OrderController::class, 'submit'])->name('cart.submit');


Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');

Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// الاشعارات
Route::post('/notifications/mark-as-read', function () {
    auth('store_houses')->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'success']);
})->name('notifications.read');
