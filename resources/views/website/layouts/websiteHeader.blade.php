<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pharma &mdash; Colorlib Template</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/fonts/icomoon/style.css') }}" />

  <link rel="stylesheet" href="{{ asset('WebsiteAssets/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/css/magnific-popup.css') }}" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/css/jquery-ui.css') }}" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/css/owl.carousel.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/css/owl.theme.default.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/img/css/aos.css') }}" />
  <link rel="stylesheet" href="{{ asset('WebsiteAssets/css/style.css') }}" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> <!-- أيقونات فيسبوك -->
</head>

<body>

  <div class="site-wrap">

    <div class="site-navbar py-2">

      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Search keyword and hit enter..." />
          </form>
        </div>
      </div>

      <div class="container">
        <div class="d-flex align-items-center justify-content-between">

          <div class="logo">
            <div class="site-logo">
              <a href="{{ route('homePage') }}" class="js-logo-clone">Pharma</a>
            </div>
          </div>

          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
                <li><a href="{{ route('homePage') }}">HOME</a></li>
                <li><a href="{{ route('products') }}">Products</a></li>
                <li><a href="{{ route('favorites') }}"> My Favorites</a></li>
                <li><a href="{{ route('pharmacy.offers') }}"> Offers</a></li>
                <li><a href="{{ route('reports.pharmacy.index') }}">Reports</a></li>
                <li><a href="{{ route('pharmacy.orders') }}">My Orders</a></li>
                <li><a href="{{ route('pharmacy.tickets.index') }}">My tickets</a></li>
              </ul>
            </nav>
          </div>
<!-- زر السلة -->
<a id="cart-toggle"
   style="
       position: fixed;
       top: 16px;
       right: 20px;
       font-size: 25px;
       color: black;
       z-index: 999;
   ">
    <i class="fas fa-shopping-cart"></i>
</a>

<!-- قائمة السلة الجانبية -->
<div id="cart-dropdown"
     style="display: none; position: fixed; top: 70px; right: 20px; width: 300px; background: #fff; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); padding: 15px; z-index: 1000;">
    <h5 class="text-center mb-3">Cart Items</h5>
    <div id="cart-items" style="max-height: 300px; overflow-y: auto;"></div>
    <div class="text-end mt-3">
        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-primary">View Cart</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // تحديث رقم السلة
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalQty = cart.reduce((sum, item) => sum + (item.quantity || 0), 0);
        document.getElementById('cart-count').textContent = totalQty;
    }

    // عرض محتوى السلة
    function updateCartPreview() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cart-items');
        container.innerHTML = '';

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-center">Your cart is empty.</p>';
            return;
        }

        cart.forEach(item => {
            const div = document.createElement('div');
            div.innerHTML = `
                <div class="mb-2 d-flex justify-content-between">
                    <span><strong>${item.name || 'Medicine #' + item.id}</strong> x${item.quantity}</span>
                    <span>$${(item.price || 0).toFixed(2)}</span>
                </div>
            `;
            container.appendChild(div);
        });
    }

    // فتح قائمة السلة
    const toggleBtn = document.getElementById('cart-toggle');
    toggleBtn?.addEventListener('click', () => {
        const dropdown = document.getElementById('cart-dropdown');
        const isVisible = dropdown.style.display === 'block';
        dropdown.style.display = isVisible ? 'none' : 'block';
        if (!isVisible) updateCartPreview();
    });

    
    updateCartCount();
});
</script>



         <a href="{{ route('admin.logout') }}" 
   class="btn btn-sm btn-outline-primary" 
   style="border-radius: 15px; padding: 6px 15px;">
    <i class="ti-power-off"></i> Logout
</a>

<!-- الجرس -->
@php
    $user = auth('pharmacy')->user();
    $notifications = $user->notifications->take(5); // نعرض آخر 5 إشعارات
    $unread = $user->unreadNotifications->count();
@endphp

<div class="notification-wrapper">
    <div class="notification-icon" onclick="togglePharmacyNotifications()">
        <i class="fas fa-bell"></i>
        @if ($unread > 0)
            <span class="red-dot" id="pharmacy-red-dot"></span>
        @endif
    </div>

    <div class="notifications-dropdown" id="pharmacy-notifications-dropdown">
        @forelse($notifications as $notification)
            <div class="notification-item">
                <strong>{{ $notification->data['title'] ?? 'New Notification' }}</strong><br>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <div class="notification-item">
                No notifications
            </div>
        @endforelse
    </div>
</div>


        </div>
      </div>
    </div>
   
    <style>
.notification-wrapper {
    position: relative;
    display: inline-block;
    margin-left: 20px;
}

.notification-icon {
    font-size: 22px;
    color: #333;
    cursor: pointer;
    position: relative;
}

.notification-icon .red-dot {
    position: absolute;
    top: 0;
    right: -2px;
    width: 8px;
    height: 8px;
    background-color: red;
    border-radius: 50%;
    border: 2px solid white;
}

.notifications-dropdown {
    position: absolute;
    top: 35px;
    right: 0;
    width: 280px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: none;
    z-index: 999;
}

.notifications-dropdown.active {
    display: block;
}

.notification-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}
</style>
<script>
function togglePharmacyNotifications() {
    const dropdown = document.getElementById("pharmacy-notifications-dropdown");
    const redDot = document.getElementById("pharmacy-red-dot");

    dropdown.classList.toggle("active");

    // نخفي النقطة الحمراء مباشرة (بدون تعديل بالباك)
    if (redDot) {
        redDot.style.display = "none";
    }
}
</script>