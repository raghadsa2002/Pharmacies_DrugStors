@include('website.layouts.websiteHeader')

<div class="site-blocks-cover" style="background-image: url({{asset('WebsiteAssets/images/hero_1.jpg')}});">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 mx-auto order-lg-2 align-self-center">
        <div class="site-block-cover-content text-center">
          <h2 class="sub-title">Explore available medicines, place orders, view offers, and manage your favorites — all in one place.</h2>
          <h1>Welcome To Pharmacist page</h1>
          <p><a href="#" class="btn btn-primary px-5 py-3">Shop Now</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row align-items-stretch section-overlap">
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="banner-wrap bg-primary h-100">
          <a href="#" class="h-100">
            <h5>Free <br> Shipping</h5>
            <p>Amet sit amet dolor <strong>Lorem, ipsum dolor sit amet consectetur adipisicing.</strong></p>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="banner-wrap h-100">
          <a href="#" class="h-100">
            <h5>Season <br> Sale 50% Off</h5>
            <p>Amet sit amet dolor <strong>Lorem, ipsum dolor sit amet consectetur adipisicing.</strong></p>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="banner-wrap bg-warning h-100">
          <a href="#" class="h-100">
            <h5>Buy <br> A Gift Card</h5>
            <p>Amet sit amet dolor <strong>Lorem, ipsum dolor sit amet consectetur adipisicing.</strong></p>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="title-section text-center col-12">
        <h2 class="text-uppercase">Popular Products</h2>
      </div>
    </div>

    <div class="row">
      @foreach ($medicines as $medicine)
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <span class="tag">{{ $medicine->name }}</span>
        <a href="shop-single.html">
        <img src="{{ asset('DashboardAssets/images/' . $medicine->image) }}" alt="{{ $medicine->name }}" style="width: 200px; height: 200px; object-fit: cover;">
        </a>
        <h3 class="text-dark"><a href="shop-single.html">{{ $medicine->name }}</a></h3>
        <p class="price">الشركة: {{ $medicine->company?->name ?? 'غير محددة' }}</p>
<p class="price">الفئة: {{ $medicine->category?->name ?? 'غير محددة' }}</p>
<p class="price">المستودع: {{ $medicine->storehouse?->name ?? 'غير محددة' }}</p>
@if($medicine->discount)
  <p class="text-muted"><del>${{ $medicine->price }}</del></p>
  <p class="text-danger">${{ $medicine->discount->discounted_price }}</p>
@else
  <p class="text-muted" style="visibility: hidden;"><del>--</del></p>
  <p>${{ $medicine->price }}</p>
@endif
        
        <!-- زر إضافة إلى المفضلة -->
      <span 
  class="favorite-icon" 
  data-id="{{ $medicine->id }}" 
  data-name="{{ $medicine->name }}" 
  data-image="{{ asset('DashboardAssets/images/' . $medicine->image) }}" 
  data-price="{{ $medicine->price }}" 
  style="cursor: pointer; color: gray; font-size: 24px;">
  <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.7692 6.70483C9.53846 2.01902 4 3.90245 4 8.68256C4 13.4627 13.2308 20 13.2308 20C13.2308 20 22 13.2003 22 8.68256C22 4.16479 16.9231 2.01903 13.6923 6.70483L13.2308 7.0791L12.7692 6.70483Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
</span>

        <button class="btn btn-primary px-4 py-3 order-now" data-medicine-id="{{ $medicine->id }}" data-medicine-name="{{ $medicine->name }}">Order Now</button>
      </div>
      @endforeach
    </div>

    <div class="row mt-5">
      <div class="col-12 text-center">
        <a href="{{route('products')}}" class="btn btn-primary px-4 py-3">View All Products</a>
      </div>
    </div>
  </div>
</div>

<div id="orderModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
  <div class="modal-content" style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #fff;">
    <h4 id="modalMedicineName">Order Medicine</h4>
    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
      @csrf
      <input type="hidden" id="medicine_id" name="medicine_id">
      <div class="form-group">
        <label for="medicine_name">Medicine Name</label>
        <input type="text" id="medicine_name" name="medicine_name" class="form-control" readonly>
      </div>
      <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" class="form-control" required min="1">
      </div>
      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" class="btn btn-secondary close-modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('orderModal');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    document.querySelectorAll('.order-now').forEach(button => {
        button.addEventListener('click', function () {
            const medicineId = this.getAttribute('data-medicine-id');
            const medicineName = this.getAttribute('data-medicine-name');

            document.getElementById('modalMedicineName').textContent = "Order " + medicineName;
            document.getElementById('medicine_id').value = medicineId;
            document.getElementById('medicine_name').value = medicineName;

            modal.style.display = 'flex';
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // التعامل مع إضافة إلى المفضلة
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

    document.querySelectorAll('.favorite-icon').forEach(icon => {
        const id = icon.getAttribute('data-id');
        const isFavorite = favorites.some(fav => fav.id === id);
        if (isFavorite) {
            icon.style.color = 'red';
        }

        icon.addEventListener('click', function () {
            const product = {
                id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                image: this.getAttribute('data-image'),
                price: this.getAttribute('data-price')
            };

            const isFavorite = favorites.some(fav => fav.id === product.id);
            if (!isFavorite) {
                favorites.push(product);
                localStorage.setItem('favorites', JSON.stringify(favorites));
                this.style.color = 'red'; // تغيير اللون إلى الأحمر
                alert(product.name + " has been added to your favorites!");
            } else {
                favorites = favorites.filter(fav => fav.id !== product.id);
                localStorage.setItem('favorites', JSON.stringify(favorites));
                this.style.color = 'gray'; // تغيير اللون إلى الرمادي
                alert(product.name + " has been removed from your favorites!");
            }
        });
    });
});
</script>

@include('website.layouts.websiteFooter')