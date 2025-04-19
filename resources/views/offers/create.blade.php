<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Offer</title>

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
                    <h4 class="card-title">Create Offer</h4>

                    <form method="POST" action="{{ route('offers.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Offer Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="medicine_id_1">Medicine 1</label>
                            <select name="medicine_id_1" id="medicine_id_1" class="form-control">
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="medicine_id_2">Medicine 2</label>
                            <select name="medicine_id_2" id="medicine_id_2" class="form-control">
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discount_price">Discount Price</label>
                            <input type="number" name="discount_price" id="discount_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Offer</button>
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.Admin.Footer')
    </div>
    @include('layouts.Admin.LinkJS')
</body>
</html>