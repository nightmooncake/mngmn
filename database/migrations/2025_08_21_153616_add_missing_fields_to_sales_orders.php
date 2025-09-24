<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {

            if (!Schema::hasColumn('sales_orders', 'customer_name')) {
                $table->string('customer_name')->after('id');
            }

            if (!Schema::hasColumn('sales_orders', 'order_date')) {
                $table->date('order_date')->after('customer_name');
            }

            if (!Schema::hasColumn('sales_orders', 'product_id')) {
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->after('order_date');
            }

            if (!Schema::hasColumn('sales_orders', 'quantity')) {
                $table->integer('quantity')->after('product_id');
            }

            if (!Schema::hasColumn('sales_orders', 'unit_price')) {
                $table->integer('unit_price')->after('quantity');
            }

            if (!Schema::hasColumn('sales_orders', 'total')) {
                $table->integer('total')->after('unit_price');
            }

            if (!Schema::hasColumn('sales_orders', 'status')) {
                $table->string('status')->after('total');
            }

            if (!Schema::hasColumn('sales_orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'customer_name',
                'order_date',
                'product_id',
                'quantity',
                'unit_price',
                'total',
                'status',
                'user_id'
            ]);
        });
    }
};