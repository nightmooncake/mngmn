<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventColumnToActivityLogTable extends Migration
{
public function up()
{
    if (!Schema::hasColumn('activity_log', 'event')) {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->string('event')->nullable()->after('subject_type');
            $table->index('event');
        });
    }
}
    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropColumn('event');
        });
    }
}
