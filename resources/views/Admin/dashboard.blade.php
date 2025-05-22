<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pharm Store Admin</title>

  @include('layouts.Admin.LinkHeader')
  @include('layouts.Admin.LinkSideBar')
</head>

<body>
  <div class="container-scroller">
    @include('layouts.Admin.Header')

    <div class="container-fluid page-body-wrapper">
      @include('layouts.Admin.Sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome {{ session()->get('actor') }}</h3>
                  <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                </div>
              </div>
            </div>
          </div>

          {{-- Dashboard Cards Based on Actor --}}
          @if(session()->get('actor') === 'admin')
            <div class="row">
              <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-tale">
                  <div class="card-body">
                    <p class="mb-4">Total Pharmacies</p>
                    <p class="fs-30 mb-2">{{ $pharmacyCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                  <div class="card-body">
                    <p class="mb-4">Total Storehouses</p>
                    <p class="fs-30 mb-2">{{ $storeHouseCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                  <div class="card-body">
                    <p class="mb-4">Total Admins</p>
                    <p class="fs-30 mb-2">{{ $adminCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-6 stretch-card transparent">
                <div class="card card-light-danger">
                  <div class="card-body">
                    <p class="mb-4">Pharmaceutical Companies</p>
                    <p class="fs-30 mb-2">{{ $pharmaceuticalCompaniesCount ?? 0 }}</p>
                  </div>
                </div>
              </div>
            </div>

          @elseif(session()->get('actor') === 'storehouse')
            <div class="row">
              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-tale">
                  <div class="card-body">
                    <p class="mb-4">Your Medicines</p>
                    <p class="fs-30 mb-2">{{ $medicineCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                  <div class="card-body">
                    <p class="mb-4">Your Employees</p>
                    <p class="fs-30 mb-2">{{ $employeeCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                  <div class="card-body">
                    <p class="mb-4">Your Orders</p>
                    <p class="fs-30 mb-2">{{ $ordersCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                  <div class="card-body">
                    <p class="mb-4">Your Offers</p>
                    <p class="fs-30 mb-2">{{ $offersCount ?? 0 }}</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-success">
                  <div class="card-body">
                    <p class="mb-4">Your Discounts</p>
                    <p class="fs-30 mb-2">{{ $discountCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mb-4 stretch-card transparent">
                <div class="card card-warning">
                  <div class="card-body">
                    <p class="mb-4">Stock Movements</p>
                    <p class="fs-30 mb-2">{{ $stockCount ?? 0 }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-12 mb-4 stretch-card transparent">
                <div class="card card-secondary">
                  <div class="card-body">
                    <p class="mb-4">Reports</p>
                    <p class="fs-30 mb-2">{{ $reportCount ?? 0 }}</p>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

        @include('layouts.Admin.Footer')
      </div>
    </div>
  </div>

  @include('layouts.Admin.LinkJS')
</body>
</html>