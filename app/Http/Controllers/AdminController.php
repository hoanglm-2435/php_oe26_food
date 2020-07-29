<?php

namespace App\Http\Controllers;

use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $orderItemRepo;

    public function __construct(OrderItemRepositoryInterface $orderItemRepo)
    {
        $this->orderItemRepo = $orderItemRepo;
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications();
        $notifyUnread = $notifications
            ->wherePivot('status', config('realtime_notify.status.notify_unread'))
            ->count();
        $getLimitNotify = Auth::user()->notifications
            ->sortByDesc('created_at')
            ->take(config('realtime_notify.show_notify'));

        return view('admin.dashboard', compact(
            'notifications',
            'notifyUnread',
            'getLimitNotify'
        ));
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

    public function getNotification(Request $request)
    {
        $notifyId = $request->id;
        $notifications = Auth::user()->notifications();
        $notifications->updateExistingPivot(
            $notifyId,
            ['status' => config('realtime_notify.status.notify_read')]
        );
        $orderId = $request->order_id;
        $orderItem = $this->orderItemRepo->getWhereEqual('order_id', $orderId);
        $orderDetails = [];
        $grandTotal = config('numbers.zero');

        foreach ($orderItem as $id => $item) {
            $orderDetails[] = [
                'productName' => $item->product->name,
                'productQuantity' => $item->quantity,
                'productPrice' => $item->product->price_sale,
                'totalPrice' => $item->total_price,
            ];
            $grandTotal += $item->total_price;
        }
        $notifyCount = $notifications
            ->wherePivot('status', config('realtime_notify.status.notify_unread'))
            ->count();

        return response()->json([
            'order_details' => $orderDetails,
            'notify_count' => $notifyCount,
            'grand_total' => $grandTotal
        ]);
    }
}
