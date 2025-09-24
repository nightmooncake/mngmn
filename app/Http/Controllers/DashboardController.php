<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $categoryFilter = $request->input('category');

        $totalSalesOrders = SalesOrder::count();
        $totalStock = Product::get()->sum('stock');

        $topSellingProducts = Product::with('sales')
            ->get()
            ->map(fn($p) => ['product' => $p, 'sold' => $p->sales->sum('quantity')])
            ->filter(fn($i) => $i['sold'] > 0)
            ->sortByDesc('sold')
            ->take(5)
            ->pluck('product');

        $productsToRestock = Product::get()->filter(fn($p) => $p->stock <= 3);
        if ($categoryFilter) {
            $productsToRestock = $productsToRestock->where('category_id', $categoryFilter);
        }

        $salesQuery = SalesOrder::selectRaw('DATE(order_date) as date, SUM(total) as total');
        if ($categoryFilter) {
            $salesQuery->join('products', 'sales_orders.product_id', '=', 'products.id')
                       ->where('products.category_id', $categoryFilter);
        }
        $salesData = $salesQuery
            ->where('order_date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($item) => [
                'date' => \Carbon\Carbon::parse($item->date)->format('d M'),
                'total' => (float)$item->total,
            ]);

        $categoryContribution = collect();
        if (Schema::hasTable('sales_orders') && Schema::hasColumn('products', 'category_id')) {
            $catQuery = DB::table('sales_orders')
                ->join('products', 'sales_orders.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id');
            if ($categoryFilter) {
                $catQuery->where('categories.id', $categoryFilter);
            }
            $categoryContribution = $catQuery
                ->selectRaw('categories.name as category, SUM(sales_orders.total) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get()
                ->map(fn($item) => ['category' => $item->category, 'total' => (float)$item->total]);
        }
        if ($categoryContribution->isEmpty()) {
            $categoryContribution = collect([['category' => 'Belum Ada Data', 'total' => 1]]);
        }

        $stockByCategoryQuery = Product::with('category')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category, SUM(products.stock) as total_stock');
        if ($categoryFilter) {
            $stockByCategoryQuery->where('categories.id', $categoryFilter);
        }
        $stockByCategory = $stockByCategoryQuery
            ->groupBy('category')
            ->get()
            ->map(fn($item) => [
                'category' => $item->category,
                'total_stock' => (int)$item->total_stock,
            ]);
        if ($stockByCategory->isEmpty()) {
            $stockByCategory = collect([['category' => 'Belum Ada Data', 'total_stock' => 0]]);
        }

        $recentTransactions = SalesOrder::with('product')
            ->whereHas('product')
            ->latest('order_date')
            ->paginate(10);

        $totalCategories = DB::table('categories')->count();
        $totalProducts = Product::count();
        $avgStockPerProduct = $totalProducts > 0 ? round($totalStock / $totalProducts, 1) : 0;
        $lowStockRatio = round(($productsToRestock->count() / max($totalProducts, 1)) * 100, 1);
        $topCategory = $stockByCategory->first() ? $stockByCategory->first()['category'] : '–';

        $trashedProducts = Product::onlyTrashed()->count();
        $trashedSalesOrders = SalesOrder::onlyTrashed()->count();
        
        $trashedProductsList = Product::onlyTrashed()->get(); 

        $allCategories = DB::table('categories')->orderBy('name')->get();

        return view('dashboard', compact(
            'totalSalesOrders',
            'totalStock',
            'topSellingProducts',
            'productsToRestock',
            'salesData',
            'categoryContribution',
            'stockByCategory',
            'recentTransactions',
            'totalCategories',
            'totalProducts',
            'avgStockPerProduct',
            'lowStockRatio',
            'topCategory',
            'trashedProducts',
            'trashedSalesOrders',
            'trashedProductsList', 
            'allCategories'
        ));
    }
}
