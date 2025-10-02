<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }
    public function create() {
        return view('suppliers.create');
    }
    public function store(StoreSupplierRequest $request) {
        Supplier::create($request->validated());
        return redirect()->route('suppliers.index')->with('status', 'Pemasok berhasil ditambahkan!');
    }
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }
    public function update(UpdateSupplierRequest $request, $id) {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->validated());
        return redirect()->route('suppliers.index')->with('status', 'Pemasok berhasil diperbarui!');
    }
    public function destroy($id) {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('status', 'Pemasok berhasil dihapus!');
    }
}