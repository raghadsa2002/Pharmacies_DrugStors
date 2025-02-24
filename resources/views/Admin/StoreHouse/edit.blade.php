<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Store House</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->

        @include('layouts.Admin.Header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->

         <!-- @include('layouts.Admin.Setting') -->


            <!-- partial -->
            <!-- partial:../../partials/_sidebar.html -->

            @include('layouts.Admin.Sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update Store House</h4>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="forms-sample"
                                        action="{{ route('admin.storeHouse.update', $storeHouse->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label>
                                            <input type="text" class="form-control" id="exampleInputName1"
                                                placeholder="Name" name="name" value="{{ $storeHouse->name }}"
                                                required>
                                        </div>
                                
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Status</label>
                                            <select class="form-control" id="exampleSelectGender" name="status"
                                                required>
                                                <option value="1" {{ $storeHouse->status === 1 ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0" {{ $storeHouse->status === 0 ? 'selected' : '' }}>
                                                    Not Active</option>
                                            </select>
                                        </div>
                                    

                                        <div class="form-group">
                                            <label for="exampleInputCity1">Phone(10 Number)</label>
                                            <input type="tel" class="form-control" id="exampleInputCity1"
                                                placeholder="0987654321" name="phone" value="{{ $storeHouse->phone }}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">City</label>
                                            <input type="text" class="form-control" id="exampleInputCity1"
                                                placeholder="Location" name="city" value="{{ $storeHouse->city }}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">Address</label>
                                            <input type="text" class="form-control" id="exampleInputCity1"
                                                placeholder="Location" name="address" value="{{ $storeHouse->address }}"
                                                required>
                                        </div>

                                        <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ $storeHouse->email }}">
</div>

<div class="form-group">
    <label for="password">Password (Leave blank to keep current password)</label>
    <input type="password" class="form-control" id="password" name="password">
</div>

                                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                                        <button class="btn btn-light">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- content-wrapper ends -->

                @include('layouts.Admin.Footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    @include('layouts.Admin.LinkJS')
</body>

</html>
