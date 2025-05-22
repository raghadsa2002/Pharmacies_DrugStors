<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Storehouse Reports</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-container {
            height: 250px;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('layouts.Admin.Header')

    <div class="container-fluid page-body-wrapper">
        @include('layouts.Admin.Sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <h2 class="text-center mb-4" style="color:rgb(28, 33, 33);">Storehouse Reports</h2>

                <div class="row">
                    <!-- Yearly Orders -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Yearly Orders (Months)</h5>
                                <div class="chart-container">
                                    <canvas id="yearlyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders by Status -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Orders by Status</h5>
                                <div class="chart-container">
                                    <canvas id="statusBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Orders -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Monthly Orders (Last 30 days)</h5>
                                <div class="chart-container">
                                    <canvas id="monthlyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Medicines -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Popular Medicines</h5>
                                <div class="mx-auto chart-container" style="max-width: 260px;">
                                    <canvas id="popularMedicinesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- Stock Quantities -->
<div class="col-md-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Current Stock Quantities</h5>
            <div class="chart-container">
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>
</div>  

            </div> <!-- content-wrapper -->

            @include('layouts.Admin.Footer')
        </div> <!-- main-panel -->
    </div> <!-- page-body-wrapper -->
</div> <!-- container-scroller -->

@include('layouts.Admin.LinkJS')

<!-- Chart Scripts -->
<script>
    // Define theme colors
    const themeColors = [
        '#4BC0C0', // Main teal color
        '#20c997', // Teal lighter
        '#17a2b8', // Info blue
        '#6610f2', // Purple
        '#6f42c1', // Purple lighter
        '#fd7e14', // Orange
        '#ffc107', // Yellow
        '#198754', // Green
        '#0d6efd', // Blue
        '#dc3545', // Red
        '#adb5bd', // Gray light
        '#6c757d'  // Gray
    ];

    // Yearly Orders (Doughnut)
    const yearlyLabels = @json($yearlyChart['labels']);
    const yearlyData = @json($yearlyChart['data']);
    new Chart(document.getElementById('yearlyChart'), {
        type: 'doughnut',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: 'Yearly Orders',
                data: yearlyData,
                backgroundColor: themeColors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Orders by Status (Bar)
    const statusBarLabels = ['Pending', 'Approved', 'Rejected'];
    const statusBarData = @json([$statusCounts['pending'], $statusCounts['approved'], $statusCounts['rejected']]);
    const statusBarColors = ['#fd7e14', '#4BC0C0', '#dc3545']; // Orange, teal, red
    new Chart(document.getElementById('statusBarChart'), {
        type: 'bar',
        data: {
            labels: statusBarLabels,
            datasets: [{
                label: 'Order Count',
                data: statusBarData,
                backgroundColor: statusBarColors,
                borderWidth: 1,
                barThickness: 25
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // Monthly Orders (Line)
    const monthlyLabels = @json($monthlyOrders->pluck('day'));
    const monthlyData = @json($monthlyOrders->pluck('total'));
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Orders',
                data: monthlyData,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // transparent teal
                borderColor: '#4BC0C0', // main teal
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 }
                }
            }
        }
    });

    // Popular Medicines (Pie)
    const popularLabels = @json($popularMedicines->pluck('name'));
    const popularData = @json($popularMedicines->pluck('total'));
    new Chart(document.getElementById('popularMedicinesChart'), {
        type: 'pie',
        data: {
            labels: popularLabels,
            datasets: [{
                label: 'Medicine Orders',
                data: popularData,
                backgroundColor: themeColors.slice(0, popularLabels.length)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    
  // Stock Quantities (Bar)
const stockLabels = @json($stockQuantities->pluck('name'));
const stockData = @json($stockQuantities->pluck('quantity'));
new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
        labels: stockLabels,
        datasets: [{
            label: 'Stock Quantity',
            data: stockData,
            backgroundColor: themeColors.slice(0, stockLabels.length),
            borderWidth: 1,
            barThickness: 25
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, precision: 0 }
            }
        }
    }
});

</script>
</body>
</html>