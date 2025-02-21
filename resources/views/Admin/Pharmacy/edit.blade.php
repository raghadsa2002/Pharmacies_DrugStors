<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Pharmacy</title>

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
                                    <h4 class="card-title">Update Pharmacy</h4>

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
                                        action="{{ route('admin.pharmacy.update', $pharmacy->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label>
                                            <input type="text" class="form-control" id="exampleInputName1"
                                                placeholder="Name" name="name" value="{{ $pharmacy->name }}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Email</label>
                                            <input type="email" class="form-control" id="exampleInputEmail3"
                                                placeholder="Email" name="email" value="{{ $pharmacy->email }}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Status</label>
                                            <select class="form-control" id="exampleSelectGender" name="status"
                                                required>
                                                <option value="1" {{ $pharmacy->status === 1 ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0" {{ $pharmacy->status === 0 ? 'selected' : '' }}>
                                                    Not Active</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" name="img" class="file-upload-default"
                                                style="display: none;">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled
                                                    placeholder="Upload Image">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary"
                                                        type="button">Upload</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">Phone(7 Number)</label>
                                            <input type="tel" class="form-control" id="exampleInputCity1"
                                                placeholder="2213423" name="phone" value="{{ $pharmacy->phone }}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">City</label>
                                            <input type="text" class="form-control" id="exampleInputCity1"
                                                placeholder="Location" name="city" value="{{ $pharmacy->city }}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">Address</label>
                                            <input type="text" class="form-control" id="exampleInputCity1"
                                                placeholder="Location" name="address" value="{{ $pharmacy->address }}"
                                                required>
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
    <script>
        document.querySelector('.file-upload-browse').addEventListener('click', function() {
            document.querySelector('.file-upload-default').click(); // Trigger the file input click
        });

        document.querySelector('.file-upload-default').addEventListener('change', function() {
            let fileName = this.files[0].name; // Get the file name
            document.querySelector('.file-upload-info').value = fileName; // Display file name in the text input
        });
    </script>
</body>

</html>
