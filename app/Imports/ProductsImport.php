<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\Importable;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, WithBatchInserts, WithChunkReading, WithEvents
{
    use Importable;

    private $categories = [];
    private $suppliers = [];

    public function model(array $row)
    {
        $supplierName = $row['supplier_name'] ?? 'Tanpa Supplier';
        if (!isset($this->suppliers[$supplierName])) {
            $this->suppliers[$supplierName] = Supplier::firstOrCreate(
                ['name' => $supplierName],
                ['contact_person' => 'Tidak Diketahui']
            );
        }
        $supplier = $this->suppliers[$supplierName];

        $categoryName = $row['category_name'] ?? 'Tanpa Kategori';
        if (!isset($this->categories[$categoryName])) {
            $this->categories[$categoryName] = Category::firstOrCreate(['name' => $categoryName]);
        }
        $category = $this->categories[$categoryName];

        return new Product([
            'name' => $row['name'],
            'price' => $row['price'] ?? 0,
            'description' => $row['description'] ?? null,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.price' => 'nullable|numeric|min:0',
            '*.supplier_name' => 'nullable|string',
            '*.category_name' => 'nullable|string',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onError(\Throwable $e)
    {
    }

    public function onFailure(...$failures)
    {
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->categories = [];
                $this->suppliers = [];
            },
        ];
    }
}
