<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('suppliers', 'contact_person')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->string('contact_person')->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('suppliers', 'contact_person')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->dropColumn('contact_person');
            });
        }
    }
};
