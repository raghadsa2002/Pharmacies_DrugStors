<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
      <li class="nav-item2">
          <a class="nav-link" href="{{route('admin.index')}}">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
          </a>
      </li>



      <li class="nav-item2">
    <a class="nav-link" data-toggle="collapse" href="#categories-basic" aria-expanded="false" aria-controls="categories-basic">
        <i style="margin-right: 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 16" width="24" height="12" fill="currentColor">
                <path d="M2 8a6 6 0 0 1 6-6h16a6 6 0 0 1 0 12H8a6 6 0 0 1-6-6z" fill="#000"/>
                <path d="M10 2h12v12H10z" fill="#FFF"/>
            </svg>
        </i>
        <span class="menu-title">Categories</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="categories-basic">
        <ul>
            <li class="nav-item2"><a class="nav-link" href="{{route('categories.index')}}">Category Table</a></li>
            <li class="nav-item2"><a class="nav-link" href="{{route('categories.create')}}">Create Category</a></li>
        </ul>
    </div>
</li>




<li class="nav-item2">
    <a class="nav-link" data-toggle="collapse" href="#medicines-basic" aria-expanded="false" aria-controls="categories-basic">
        <i style="margin-right: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-capsule" viewBox="0 0 16 16">
                      <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429z"/>
                  </svg>
        </i>
        <span class="menu-title">medicines</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="medicines-basic">
        <ul>
            <li class="nav-item2"><a class="nav-link" href="{{route('medicines.index')}}">medicines Table</a></li>
            <li class="nav-item2"><a class="nav-link" href="{{route('medicines.create')}}">add medicin</a></li>
            
        </ul>
    </div>
</li>



      <li class="nav-item2">
          <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i style="margin-right: 14px;">
      <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M724.5 615.6L546.6 437.8c-3.4-3.4-3.4-9 0-12.5l143.6-143.6c50.5-50.4 133-50.4 183.5 0 54.2 54.2 54.2 142.9 0 197.1L736.9 615.6c-3.4 3.4-9 3.4-12.4 0z" fill="#210d0d"></path><path d="M238.2 222.1c37.2 0 72.1 14.4 98.2 40.5l149 149.1L289 608 140 458.9c-26.1-26.1-40.5-61-40.5-98.2s14.4-72.1 40.5-98.2 61-40.4 98.2-40.4m0-15c-39.4 0-78.9 15-108.8 44.9-59.8 59.8-59.8 157.7 0 217.6L289 629.2l217.6-217.6L347 252c-29.9-30-69.3-44.9-108.8-44.9z" fill="#999999"></path><path d="M784.5 222.1c37.2 0 72.1 14.4 98.2 40.5 26.1 26.1 40.5 61 40.5 98.2s-14.4 72.1-40.5 98.2L733.6 608 537.2 411.6l149.1-149c26.1-26.1 61-40.5 98.2-40.5m0-15c-39.4 0-78.9 15-108.8 44.8L516 411.6l217.6 217.6 159.7-159.6c59.9-59.8 59.9-157.8 0-217.6-30-29.9-69.4-44.9-108.8-44.9zM570.6 623.7c6.4 0 11.6 5.2 11.6 11.6 0 6.4-5.2 11.6-11.6 11.6-3.1 0-6-1.2-8.2-3.4s-3.4-5.1-3.4-8.2c0-6.4 5.2-11.6 11.6-11.6m0.1-15c-14.7 0-26.6 11.9-26.6 26.6s11.9 26.6 26.6 26.6c14.7 0 26.6-11.9 26.6-26.6 0-14.7-11.9-26.6-26.6-26.6z" fill="#312626"></path><path d="M454.8 622.6c6.4 0 11.6 5.2 11.6 11.6s-5.2 11.6-11.6 11.6c-3.1 0-6-1.2-8.2-3.4s-3.4-5.1-3.4-8.2c0-3.1 1.2-6 3.4-8.2s5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6s26.6-11.9 26.6-26.6c0.1-14.7-11.9-26.6-26.6-26.6zM569.3 757.7c3.1 0 6 1.2 8.2 3.4s3.4 5.1 3.4 8.2c0 3.1-1.2 6-3.4 8.2s-5.1 3.4-8.2 3.4-6-1.2-8.2-3.4-3.4-5.1-3.4-8.2c0-3.1 1.2-6 3.4-8.2 2.2-2.1 5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6s26.6-11.9 26.6-26.6c0.1-14.6-11.9-26.6-26.6-26.6zM453.5 756.6c3.1 0 6 1.2 8.2 3.4s3.4 5.1 3.4 8.2c0 3.1-1.2 6-3.4 8.2-2.2 2.2-5.1 3.4-8.2 3.4-6.4 0-11.6-5.2-11.6-11.6 0-6.4 5.2-11.6 11.6-11.6m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6s26.6-11.9 26.6-26.6-11.9-26.6-26.6-26.6zM622.1 698.8c3.1 0 6 1.2 8.2 3.4s3.4 5.1 3.4 8.2c0 3.1-1.2 6-3.4 8.2s-5.1 3.4-8.2 3.4c-3.1 0-6-1.2-8.2-3.4s-3.4-5.1-3.4-8.2c0-3.1 1.2-6 3.4-8.2s5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6s11.9 26.6 26.6 26.6c14.7 0 26.6-11.9 26.6-26.6 0.1-14.7-11.9-26.6-26.6-26.6zM396.9 693.9c6.4 0 11.6 5.2 11.6 11.6 0 6.4-5.2 11.6-11.6 11.6s-11.6-5.2-11.6-11.6c0-3.1 1.2-6 3.4-8.2 2.2-2.1 5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6s26.6-11.9 26.6-26.6c0-14.6-11.9-26.6-26.6-26.6zM510.2 689.9c6.4 0 11.6 5.2 11.6 11.6 0 6.4-5.2 11.6-11.6 11.6s-11.6-5.2-11.6-11.6c0-3.1 1.2-6 3.4-8.2s5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6s26.6-11.9 26.6-26.6-11.9-26.6-26.6-26.6zM511.5 557.8c6.4 0 11.6 5.2 11.6 11.6 0 6.4-5.2 11.6-11.6 11.6-3.1 0-6-1.2-8.2-3.4s-3.4-5.1-3.4-8.2c0-3.1 1.2-6 3.4-8.2 2.2-2.2 5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6s26.6-11.9 26.6-26.6c0.1-14.7-11.9-26.6-26.6-26.6zM508.9 823.7c6.4 0 11.6 5.2 11.6 11.6 0 3.1-1.2 6-3.4 8.2s-5.1 3.4-8.2 3.4c-6.4 0-11.6-5.2-11.6-11.6 0-3.1 1.2-6 3.4-8.2s5.1-3.4 8.2-3.4m0-15c-14.7 0-26.6 11.9-26.6 26.6 0 14.7 11.9 26.6 26.6 26.6 14.7 0 26.6-11.9 26.6-26.6 0-14.7-11.9-26.6-26.6-26.6z" fill="#999999"></path></g></svg>
              </i>
              <span class="menu-title">Pharmacy Manager</span>
              <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic" data-parent="#sidebar">
              <ul>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.pharmacy.index')}}">Pharmacy Table</a></li>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.pharmacy.create')}}">Create Pharmacy</a></li>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.pharmacy.archive')}}">Pharmacy Archive Table</a></li>
              </ul>
          </div>
      </li>




      <li class="nav-item2">
          <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i style="margin-right: 14px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop-window" viewBox="0 0 16 16">
                      <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5m2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5"/>
                  </svg>
              </i>
              <span class="menu-title">Store House Manager</span>
              <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="form-elements" data-parent="#sidebar">
              <ul>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.storeHouse.index')}}">Store House Table</a></li>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.storeHouse.create')}}">Create Store House</a></li>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.storeHouse.archive')}}">Store House Archive Table</a></li>
              </ul>
          </div>
      </li>




      <li class="nav-item2">
          <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i style="margin-right: 14px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-capsule-pill" viewBox="0 0 16 16">
                      <path d="M11.02 5.364a3 3 0 0 0-4.242-4.243L1.121 6.778a3 3 0 1 0 4.243 4.243l5.657-5.657Zm-6.413-.657 2.878-2.879a2 2 0 1 1 2.829 2.829L7.435 7.536zM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8m-.5 1.042a3 3 0 0 0 0 5.917zm1 5.917a3 3 0 0 0 0-5.917z"/>
                  </svg>
              </i>
              <span class="menu-title">Pharmaceutical Companies</span>
              <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="charts">
              <ul>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.pharmaceuticalCompanies.index')}}">Pharmaceutical Companies Table</a></li>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.pharmaceuticalCompanies.create')}}">Create Pharmaceutical Companies</a></li>
                  <li class="nav-item2"><a class="nav-link" href="{{route('admin.pharmaceuticalCompanies.archive')}}">Pharmaceutical Companies Archive Table</a></li>
              </ul>
          </div>
      </li>
  </ul>
</nav>