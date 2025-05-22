<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StorehouseReportsController extends Controller
{
    public function index()
    {
        $storehouseId = auth('store_houses')->id();

        // 1. Monthly Orders (all statuses)
        $monthlyOrders = Order::select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->where('store_houses_id', $storehouseId)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // 2. Yearly Orders (all statuses)
        $yearlyRaw = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('store_houses_id', $storehouseId)
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $yearlyData = array_fill(1, 12, 0);
        foreach ($yearlyRaw as $row) {
            $yearlyData[$row->month] = $row->total;
        }
        $monthsLabels = [];
        foreach (range(1, 12) as $month) {
            $monthsLabels[] = Carbon::create()->month($month)->format('F');
        }

        // 3. Stock Quantity Report (current quantity of each medicine in this storehouse)
$stockQuantities = \App\Models\Medicine::where('store_houses_id', $storehouseId)
->select('name', 'stock') // assuming 'stock' is the column storing current quantity
->get()
->map(function ($medicine) {
    return [
        'name' => $medicine->name,
        'quantity' => $medicine->stock,
    ];
});
       

        // 4. Popular Medicines (all statuses)
        $popularMedicinesRaw = Order::select('medicine_id', DB::raw('COUNT(*) as total'))
            ->where('store_houses_id', $storehouseId)
            ->whereNotNull('medicine_id')
            ->groupBy('medicine_id')
            ->with('medicine')
            ->get();

        $totalPopularOrders = $popularMedicinesRaw->sum('total');

        $popularMedicines = $popularMedicinesRaw->map(function ($item) use ($totalPopularOrders) {
            return [
                'name' => $item->medicine->name ?? 'Unknown',
                'total' => $item->total,
                'percentage' => $totalPopularOrders > 0 ? round(($item->total / $totalPopularOrders) * 100, 2) : 0,
            ];
        })->sortByDesc('total')->values();

        // 5. Status Counts (all statuses)
        $statusCounts = [
            'pending' => Order::where('store_houses_id', $storehouseId)->where('status', 'pending')->count(),
            'approved' => Order::where('store_houses_id', $storehouseId)->where('status', 'approved')->count(),
            'rejected' => Order::where('store_houses_id', $storehouseId)->where('status', 'rejected')->count(),
        ];

        return view('report.storehouse.index', [
            'monthlyOrders' => $monthlyOrders,
            'yearlyChart' => [
                'labels' => $monthsLabels,
                'data' => array_values($yearlyData),
            ],
            'popularMedicines' => $popularMedicines,
            'statusCounts' => $statusCounts,
            'stockQuantities' => $stockQuantities, // << جديد
        ]);
    }
}