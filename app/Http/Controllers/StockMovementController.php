<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            $since = $request->query('since', 0);

            return StockMovement::with(['product:id,name', 'user:id,name'])
                ->where('id', '>', $since)
                ->latest('id')
                ->limit(50)
                ->get()
                ->map(function ($movement) {
                    return [
                        'id' => $movement->id,
                        'product' => $movement->product ? ['name' => $movement->product->name] : null,
                        'user' => $movement->user ? ['name' => $movement->user->name] : null,
                        'quantity' => $movement->quantity,
                        'type' => $movement->type,
                        'created_at' => $movement->created_at,
                    ];
                });
        }

        $stockMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->paginate(10);

        return view('stockmovements.index', compact('stockMovements'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stockmovements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
        ]);

        $product = Product::findOrFail($request->product_id);

        try {
            DB::transaction(function () use ($request, $product) {
                StockMovement::create([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'type' => $request->type,
                    'user_id' => Auth::id(),
                ]);

                if ($request->type === 'in') {
                    $product->increment('stock', $request->quantity);
                } else {
                    $available = $product->stock ?? 0;
                    if ($available < $request->quantity) {
                        throw new \Exception("Stok tidak cukup: hanya {$available} tersedia, tetapi diminta {$request->quantity}.");
                    }
                    $product->decrement('stock', $request->quantity);
                }
            });

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Pergerakan stok berhasil dicatat.']);
            }

            return redirect()->route('stockmovements.index')->with('success', 'Pergerakan stok berhasil dicatat.');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }

            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $stockMovement = StockMovement::with(['product', 'user'])->find($id);

        if (!$stockMovement) {
            return redirect()->route('stockmovements.index')
                             ->with('error', 'Pergerakan stok tidak ditemukan.');
        }

        return view('stockmovements.show', compact('stockMovement'));
    }
}
