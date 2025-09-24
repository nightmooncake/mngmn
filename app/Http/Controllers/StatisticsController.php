<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\StockMovement;
use Illuminate\Support\Carbon;

class StatisticsController extends Controller
{
    public function getStatistics()
    {
        return response()->json([
            'total_products' => Product::count(),
            'total_suppliers' => Supplier::count(),
            'trusted_suppliers' => Supplier::where('is_trusted', true)->count(),
            'purchase_orders' => PurchaseOrder::count(),
            'recent_po' => PurchaseOrder::where('order_date', '>=', Carbon::now()->subWeek())->count(),
            'sales_orders' => SalesOrder::count(),
            'recent_so' => SalesOrder::where('order_date', '>=', Carbon::now()->subWeek())->count(),
            'stock_in' => StockMovement::where('type', 'in')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('quantity'),
            'stock_out' => StockMovement::where('type', 'out')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('quantity'),
        ]);
    }
}