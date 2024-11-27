<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create category</title>

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

            @include('layouts.Admin.Setting')


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
                                    <h4 class="card-title">Create category</h4>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="forms-sample" action="{{ route('categories.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label>
                                            <input type="text" class="form-control" id="exampleInputName1"
                                                placeholder="Name" name="name" required>
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
