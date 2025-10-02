<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->string('customer_name')->after('id');
            $table->date('order_date')->after('customer_name');
            $table->unsignedInteger('product_id')->after('order_date');
            $table->integer('quantity')->after('product_id');
            $table->integer('unit_price')->after('quantity');
            $table->integer('total')->after('unit_price');
            $table->string('status')->after('total');
            $table->unsignedInteger('user_id')->nullable()->after('status');
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