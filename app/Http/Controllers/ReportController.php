<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function pharmacyReports()
    {
        $pharmacyId = Auth::guard('pharmacy')->id();
    
        // Weekly
        $weeklyRaw = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
    
        $weekly = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $weekly->push([
                'date' => $date,
                'total' => $weeklyRaw->has($date) ? $weeklyRaw[$date]->total : 0
            ]);
        }
    
        // Monthly
        $monthly = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
    
        // Daily
        $daily = Order::select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->whereDate('created_at', today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
    
        // Yearly
        $yearlyRaw = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        $months = [];
        $yearlyData = array_fill(1, 12, 0);
        foreach ($yearlyRaw as $row) {
            $yearlyData[$row->month] = $row->total;
        }
        foreach (range(1, 12) as $m) {
            $months[] = Carbon::create(null, $m, 1)->format('F');
        }
    
        // Popular Medicines
        $popular = Order::select('medicine_id', DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->whereNotNull('medicine_id')
            ->groupBy('medicine_id')
            ->with('medicine')
            ->get();
    
        $totalOrders = $popular->sum('total');
    
        $popularMedicines = $popular->map(function ($row) use ($totalOrders) {
            return [
                'name' => $row->medicine->name ?? 'Unknown',
                'total' => $row->total,
                'percentage' => $totalOrders > 0 ? round(($row->total / $totalOrders) * 100, 2) : 0
            ];
        })->sortByDesc('total')->values();
    
        // Orders by Status
        $statusCounts = [
            'pending' => Order::where('pharmacy_id', $pharmacyId)->where('status', 'pending')->count(),
            'approved' => Order::where('pharmacy_id', $pharmacyId)->where('status', 'approved')->count(),
            'rejected' => Order::where('pharmacy_id', $pharmacyId)->where('status', 'rejected')->count(),
        ];
    
        // هنا نحط return بعد ما نجهز كل شي
        return view('pharmacy.reports.index', [
            'monthlyOrders' => $monthly,
            'dailyOrders' => $daily,
            'yearlyChart' => [
                'labels' => $months,
                'data' => array_values($yearlyData)
            ],
            'popularMedicines' => $popularMedicines,
            'statusCounts' => $statusCounts
        ]);
    
    }

    
}