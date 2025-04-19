<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pharma &mdash; Colorlib Template</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('WebsiteAssets/fonts/icomoon/style.css')}}">

  <link rel="stylesheet" href="{{asset('WebsiteAssets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('WebsiteAssets/css/magnific-popup.css')}}">
  <link rel="stylesheet" href="{{asset('WebsiteAssets/css/jquery-ui.css')}}">
  <link rel="stylesheet" href="{{asset('WebsiteAssets/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('WebsiteAssets/css/owl.theme.default.min.css')}}">


  <link rel="stylesheet" href="{{asset('WebsiteAssets/img/css/aos.css')}}">

  <link rel="stylesheet" href="{{asset('WebsiteAssets/css/style.css')}}">

</head>

<body>

  <div class="site-wrap">


    <div class="site-navbar py-2">

      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
          </form>
        </div>
      </div>

      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="index.html" class="js-logo-clone">Pharma</a>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
               
                <li><a href="{{route('homePage')}}">HOME</a></li>
                <li><a href="{{route('products')}}">Products</a></li>
                <li><a href="{{ route('favorites') }}"><i class="fas fa-heart"></i>My Favorites</a></li>
                <li><a href="{{ route('orders.pharmacyOffers') }}"><i class="fas fa-heart"></i>offers</a></li>
                <li class="has-children">
                  
                  
                    </li>
                  
                </li>
                <li>
                <a href="{{ route('pharmacy.orders') }}">My Orders</a>
</li>
               
              </ul>
            </nav>
          </div>
          
          <a class="" href="{{route('admin.logout')}}">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
        </div>
      </div>
    </div>
    