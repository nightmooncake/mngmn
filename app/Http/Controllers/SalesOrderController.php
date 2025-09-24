<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::with('product', 'user')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('salesorders.index', compact('salesOrders'));
    }

    public function create()
    {
        $products = Product::with('stockMovements')->get();
        return view('salesorders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'order_date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);

        $availableStock = $product->stock;
        if ($request->quantity > $availableStock) {
            return back()->withErrors([
                'quantity' => "Stok tidak mencukupi. Tersedia: {$availableStock}"
            ])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            SalesOrder::create([
                'customer_name' => $request->customer_name,
                'order_date' => $request->order_date,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total' => $request->total,
                'status' => 'completed',
                'user_id' => auth()->id(),
            ]);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $request->quantity,
                'description' => 'Penjualan ke: ' . $request->customer_name,
                'user_id' => auth()->id(),
            ]);
        });

        return redirect()->route('salesorders.index')
                         ->with('success', 'Pesanan berhasil dibuat dan stok telah dikurangi.');
    }

    public function show(SalesOrder $salesorder)
    {
        $salesorder->load('product.category', 'product.supplier', 'user');
        return view('salesorders.show', compact('salesorder'));
    }

    public function update(Request $request, SalesOrder $salesorder)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'order_date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);

        $oldProductId = $salesorder->product_id;
        $oldQuantity = $salesorder->quantity;

        if ($request->product_id != $oldProductId) {
            $availableStock = $product->stock;
            if ($request->quantity > $availableStock) {
                return back()->withErrors([
                    'quantity' => "Stok tidak mencukupi untuk produk baru. Tersedia: {$availableStock}"
                ])->withInput();
            }
        } else {
            $additionalNeeded = $request->quantity - $oldQuantity;
            if ($additionalNeeded > 0) {
                $availableStock = $product->stock + $oldQuantity;
                if ($request->quantity > $availableStock) {
                    return back()->withErrors([
                        'quantity' => "Jumlah dinaikkan. Butuh total {$request->quantity}, stok tersedia: {$availableStock}"
                    ])->withInput();
                }
            }
        }

        DB::transaction(function () use ($request, $salesorder, $product, $oldProductId, $oldQuantity) {
            $salesorder->update([
                'customer_name' => $request->customer_name,
                'order_date' => $request->order_date,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total' => $request->total,
                'status' => 'completed',
            ]);

            if ($request->product_id != $oldProductId || $request->quantity != $oldQuantity) {
                StockMovement::create([
                    'product_id' => $oldProductId,
                    'type' => 'in',
                    'quantity' => $oldQuantity,
                    'description' => 'Pembatalan stok lama saat update pesanan: ' . $request->customer_name,
                    'user_id' => auth()->id(),
                ]);

                StockMovement::create([
                    'product_id' => $request->product_id,
                    'type' => 'out',
                    'quantity' => $request->quantity,
                    'description' => 'Update pesanan: ' . $request->customer_name,
                    'user_id' => auth()->id(),
                ]);
            }
        });

        return redirect()->route('salesorders.index')
                         ->with('success', 'Pesanan berhasil diperbarui dan stok disesuaikan.');
    }

    public function destroy(SalesOrder $salesorder)
    {
        if (in_array($salesorder->status, ['shipped', 'delivered'])) {
            return redirect()
                ->route('salesorders.show', $salesorder->id)
                ->with('error', 'Tidak bisa menghapus pesanan yang sudah dikirim.');
        }

        DB::transaction(function () use ($salesorder) {
            StockMovement::create([
                'product_id' => $salesorder->product_id,
                'type' => 'in',
                'quantity' => $salesorder->quantity,
                'description' => 'Pembatalan pesanan: ' . $salesorder->customer_name,
                'user_id' => auth()->id(),
            ]);

            $salesorder->delete();
        });

        return redirect()->route('salesorders.index')
                         ->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
    }
}
