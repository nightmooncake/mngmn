<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
    Schema::dropIfExists('sales_orders'); 
    Schema::create('sales_orders', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->date('order_date');
        $table->decimal('total', 10, 2);
        $table->string('status');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
