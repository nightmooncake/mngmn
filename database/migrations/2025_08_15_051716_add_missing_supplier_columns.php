<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            if (!Schema::hasColumn('suppliers', 'contact_person')) {
                $table->string('contact_person')->after('name');
            }
            if (!Schema::hasColumn('suppliers', 'email')) {
                $table->string('email')->after('contact_person')->nullable();
            }
            if (!Schema::hasColumn('suppliers', 'phone')) {
                $table->string('phone')->after('email')->nullable();
            }
            if (!Schema::hasColumn('suppliers', 'address')) {
                $table->string('address')->after('phone')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            if (Schema::hasColumn('suppliers', 'contact_person')) {
                $table->dropColumn('contact_person');
            }
            if (Schema::hasColumn('suppliers', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('suppliers', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('suppliers', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
