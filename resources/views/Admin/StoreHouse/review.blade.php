<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pharmacy Table</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container-scroller">
        @include('layouts.Admin.Header')

        <div class="container-fluid page-body-wrapper">
         <!-- @include('layouts.Admin.Setting') -->
            @include('layouts.Admin.Sidebar')

<div class="container mt-4">
    <h2>تقييمات الصيادلة</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>اسم الصيدلي</th>
                <th>التقييم</th>
                <th>ملاحظات</th>
                <th>تاريخ التقييم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td>{{ $review->order_id }}</td>
                <td>{{ $review->pharmacy->name ?? 'غير معروف' }}</td>
                <td>{{ $review->rating }}</td>
                <td>{{ $review->comment }}</td>
                <td>{{ $review->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('layouts.Admin.Footer')

    @include('layouts.Admin.LinkJS')
</body>

</html>
