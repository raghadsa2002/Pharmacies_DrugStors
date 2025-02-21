<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Pharmacy</title>

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
                                    <h4 class="card-title">Create Pharmacy</h4>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="forms-sample" action="{{ route('admin.pharmacy.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label>
                                            <input type="text" class="form-control" id="exampleInputName1"
                                                placeholder="Name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Email</label>
                                            <input type="email" class="form-control" id="exampleInputEmail3"
                                                placeholder="Email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword4">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword4"
                                                placeholder="Password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Status</label>
                                            <select class="form-control" id="exampleSelectGender" name="status"
                                                required>
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" name="img" class="file-upload-default"
                                                style="display: none;" required> <!-- Hide the actual input -->
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
                                                placeholder="2213423" name="phone" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">City</label>
                                            <input type="text" class="form-control" id="exampleInputCity1"
                                                placeholder="Location" name="city" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputCity1">Address</label>
                                            <input type="text" class="form-control" id="exampleInputCity1"
                                                placeholder="Location" name="address" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
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
