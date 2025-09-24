<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with('supplier')->get();

        return view('purchase_orders.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('purchase_orders.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'required|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
        ]);

        PurchaseOrder::create($validatedData);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully!');
    }

    public function edit(PurchaseOrder $purchase_order)
    {
        $suppliers = Supplier::all();

        return view('purchase_orders.edit', [
            'purchaseOrder' => $purchase_order,
            'suppliers' => $suppliers
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchase_order)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'required|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $purchase_order->update($validated);

        return redirect()->route('purchase_orders.index')
            ->with('success', 'Purchase order berhasil diperbarui.');
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->delete();

        return redirect()->route('purchase_orders.index')
                         ->with('success', 'Purchase order berhasil dihapus.');
    }
}
