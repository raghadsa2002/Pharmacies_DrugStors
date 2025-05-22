<!DOCTYPE html>
<html lang="en">
@include('website.layouts.websiteHeader')
<head>
    <meta charset="UTF-8" />
    <title>Pharmacy Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            height: 220px;
        }
    </style>
</head>
<body class="p-4">

    <h2 class="text-center" style="color: #4BC0C0; margin-bottom: 30px;">
        Pharmacy Reports
    </h2>

    <div class="row g-4">


    <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Yearly Orders (Months)</h5>
                    <div class="chart-container">
                        <canvas id="yearlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


<!-- Order Status Report -->
<div class="col-md-6">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Orders by Status</h5>
            <div class="chart-container" style="height: 220px;">
                <canvas id="statusBarChart"></canvas>
            </div>
        </div>
    </div>
</div>


       

      <!-- Monthly Orders (Line - from weekly design) -->
<div class="col-md-6">
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
 <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Popular Medicines</h5>
                    <div class="mx-auto chart-container" style="max-width: 260px;">
                        <canvas id="popularMedicinesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        
    </div>

    <!-- Chart Scripts -->
    <script>
      // Monthly Orders (Line)
      const monthlyLabels = @json($monthlyOrders->pluck('date'));
    const monthlyData = @json($monthlyOrders->pluck('total'));
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Orders',
                data: monthlyData,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });

    // Orders by Status (Doughnut)
    const statusBarLabels = ['Pending', 'Approved', 'Rejected'];
const statusBarData = @json([$statusCounts['pending'], $statusCounts['approved'], $statusCounts['rejected']]);

new Chart(document.getElementById('statusBarChart'), {
    type: 'bar',
    data: {
        labels: statusBarLabels,
        datasets: [{
            label: 'Order Count',
            data: statusBarData,
            backgroundColor: ['#FFCE56', '#4BC0C0', '#FF6384'],
            borderWidth: 1,
            barThickness: 30 // عدلي القيمة هنا لتتحكمي في عرض العمود (جربي 20 أو 25 إذا تبين أضيق)
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0,
                    stepSize: 1
                }
            }
        }
    }
});


        const yearlyLabels = @json($yearlyChart['labels']);
        const yearlyData = @json($yearlyChart['data']);
        new Chart(document.getElementById('yearlyChart'), {type: 'doughnut',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Yearly Orders',
                    data: yearlyData,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40',
                        '#8B4513', '#00CED1', '#DC143C',
                        '#2E8B57', '#4682B4', '#B22222'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const popularLabels = {!! json_encode($popularMedicines->pluck('name')) !!};
        const popularData = {!! json_encode($popularMedicines->pluck('total')) !!};
        new Chart(document.getElementById('popularMedicinesChart'), {
            type: 'pie',
            data: {
                labels: popularLabels,
                datasets: [{
                    label: 'Medicine Orders',
                    data: popularData,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56',
                        '#4BC0C0', '#9966FF', '#FF9F40'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
@include('website.layouts.websiteFooter')