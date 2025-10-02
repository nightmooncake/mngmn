<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['supplier', 'category'])
            ->withSum('stockMovements', 'quantity')
            ->orderBy('name', 'asc')
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        foreach ($products as $product) {
            $product->stock = max(0, $product->stock_movements_sum_quantity ?? 0);
        }

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('product_images', 'public');
        }
        Product::create($validatedData);
        return redirect()->route('products.index')->with('success', '✅ Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        $product = Product::withTrashed()
            ->with(['category', 'supplier', 'stockMovements'])
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('product_images', 'public');
        } else {
            $validatedData['image'] = $product->image;
        }
        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', '✅ Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '🗑️ Produk berhasil dihapus. Anda bisa mengembalikannya dari tempat sampah.');
    }

    public function trash()
    {
        $trashedProducts = Product::onlyTrashed()
            ->with(['category', 'supplier'])
            ->withSum('stockMovements', 'quantity')
            ->orderBy('deleted_at', 'desc')
            ->paginate(12);

        foreach ($trashedProducts as $product) {
            $product->stock = max(0, $product->stock_movements_sum_quantity ?? 0);
        }

        return view('products.trash', compact('trashedProducts'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $productName = $product->name;
        $product->restore();

        return redirect()->route('products.trash')->with('success', "✅ Produk '{$productName}' berhasil dikembalikan.");
    }

    public function massRestore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            $restoredCount = Product::onlyTrashed()->whereIn('id', $ids)->restore();
            return redirect()->route('products.trash')->with('success', '✅ ' . $restoredCount . ' produk berhasil dikembalikan.');
        }

        return redirect()->route('products.trash')->with('error', '⚠️ Tidak ada produk yang dipilih.');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $productName = $product->name;
        $imagePath = $product->image;

        $product->forceDelete();

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('products.trash')->with('success', "🗑️ Produk '{$productName}' dihapus permanen beserta gambarnya.");
    }

    public function massForceDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            $products = Product::onlyTrashed()->whereIn('id', $ids)->get();

            foreach ($products as $product) {
                $imagePath = $product->image;

                $product->forceDelete();

                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            return redirect()->route('products.trash')->with('success', '✅ ' . count($products) . ' produk berhasil dihapus permanen.');
        }

        return redirect()->route('products.trash')->with('error', '⚠️ Tidak ada produk yang dipilih.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('excel_file'));
            return response()->json(['message' => '✅ Import berhasil!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => '❌ Gagal mengimpor: ' . $e->getMessage()], 500);
        }
    }

    public function exportExcel()
    {
        $fileName = 'produk_' . date('Y_m_d_H_i_s') . '.xlsx';
        // return Excel::download(new ProductsExport, $fileName);
    }
}
