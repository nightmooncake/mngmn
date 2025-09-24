<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;
class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }
    public function create() {
        return view('suppliers.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);
        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('status', 'Pemasok berhasil ditambahkan!');
    }
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('status', 'Pemasok berhasil diperbarui!');
    }
    public function destroy($id) {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('status', 'Pemasok berhasil dihapus!');
    }
}