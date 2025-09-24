<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('purchase_orders', 'status')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('expected_delivery_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('purchase_orders', 'status')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
