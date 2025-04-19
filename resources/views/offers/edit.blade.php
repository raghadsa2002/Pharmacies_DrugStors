<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Offer</title>

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
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Offer</h4>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ $offer->title }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="discount_price">Discount Price</label>
                                            <input type="number" class="form-control" id="discount_price" name="discount_price" value="{{ $offer->discount_price }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="medicine_id_1">Medicine 1</label>
                                            <select class="form-control" id="medicine_id_1" name="medicine_id_1" required>
                                                <option value="">Select Medicine</option>
                                                @foreach ($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}" {{ $offer->medicine_id_1 == $medicine->id ? 'selected' : '' }}>
                                                        {{ $medicine->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="medicine_id_2">Medicine 2</label>
                                            <select class="form-control" id="medicine_id_2" name="medicine_id_2" required>
                                                <option value="">Select Medicine</option>
                                                @foreach ($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}" {{ $offer->medicine_id_2 == $medicine->id ? 'selected' : '' }}>
                                                        {{ $medicine->name }}
                                                    </option>
                                                @endforeach
                                                </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $offer->start_date }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $offer->end_date }}" required>
                                        </div>

                                    

                                        <button type="submit" class="btn btn-primary">Update Offer</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('layouts.Admin.Footer')
            </div>
        </div>
    </div>

    @include('layouts.Admin.LinkJS')
</body>

</html>