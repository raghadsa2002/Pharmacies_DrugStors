<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function pharmacyReports()
    {
        $pharmacyId = Auth::guard('pharmacy')->id();

        // Weekly Orders (آخر 7 أيام)
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

        // Monthly Orders (الشهر الحالي)
        $monthly = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Daily Orders (اليوم الحالي، حسب الساعة)
        $daily = Order::select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->where('pharmacy_id', $pharmacyId)
            ->whereDate('created_at', today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Yearly Orders (السنة الحالية)
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

        // Popular Medicines (باستخدام order_items وربطها بالطلبات)
        $popularRaw = OrderItem::select('medicine_id', DB::raw('SUM(quantity) as total'))
            ->whereHas('order', function ($query) use ($pharmacyId) {
                $query->where('pharmacy_id', $pharmacyId);
            })
            ->groupBy('medicine_id')
            ->with('medicine')
            ->get();

        $totalOrders = $popularRaw->sum('total');

        $popularMedicines = $popularRaw->map(function ($row) use ($totalOrders) {
            return [
                'name' => $row->medicine->name ?? 'Unknown',
                'total' => $row->total,
                'percentage' => $totalOrders > 0 ? round(($row->total / $totalOrders) * 100, 2) : 0,
            ];
        })->sortByDesc('total')->values();

        // Orders by Status
        $statusCounts = [
            'pending' => Order::where('pharmacy_id', $pharmacyId)->where('status', 'pending')->count(),
            'approved' => Order::where('pharmacy_id', $pharmacyId)->where('status', 'approved')->count(),
            'rejected' => Order::where('pharmacy_id', $pharmacyId)->where('status', 'rejected')->count(),
        ];

        // إرجاع البيانات للواجهة
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