<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Discount</title>

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
                    <h4 class="card-title">Create Discount</h4>

                    <form method="POST" action="{{ route('discounts.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="medicine_id">Medicine</label>
                            <select name="medicine_id" id="medicine_id" class="form-control" required>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discounted_price">Discounted Price</label>
                            <input type="number" name="discounted_price" id="discounted_price" class="form-control" required>
                        </div>
                       
                        <button type="submit" class="btn btn-primary">Create Discount</button>
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.Admin.Footer')
    </div>
    @include('layouts.Admin.LinkJS')
</body>
</html>