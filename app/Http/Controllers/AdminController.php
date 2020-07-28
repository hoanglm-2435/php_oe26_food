<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function getChart()
    {
        $year = now()->year;
        $sumData = DB::table('orders')
            ->select(
                DB::raw('SUM(quantity) as sum_order'),
                DB::raw('SUM(total_price) as sum_revenue'),
                DB::raw('MONTH(created_at) as month')
            )
            ->whereYear('created_at', $year)
            ->where('status', config('status.approved'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        $sumRevenue = array_fill(
            config('chart.start_index'),
            config('chart.end_index'),
            config('chart.default_value')
        );
        $sumOrder = array_fill(
            config('chart.start_index'),
            config('chart.end_index'),
            config('chart.default_value')
        );
        $titleChart = trans('message.chart.title');
        $revenueLabel = trans('message.chart.label.revenue');
        $orderLabel = trans('message.chart.label.number_of_orders');
        $right_label = trans('message.orders');
        $month = trans('message.chart.month');

        foreach ($sumData as $key => $sumForMonth) {
            $sumRevenue[$sumForMonth->month - 1] = $sumForMonth->sum_revenue;
            $sumOrder[$sumForMonth->month - 1] = $sumForMonth->sum_order;
        }
        $dataChart = [
            'title_chart' => $titleChart,
            'revenue_label' => $revenueLabel,
            'order_label' => $orderLabel,
            'right_label' => $right_label,
            'total_order' => $sumOrder,
            'total_revenue' => $sumRevenue,
            'labels' => $month,
        ];

        return response()->json($dataChart);
    }
}
