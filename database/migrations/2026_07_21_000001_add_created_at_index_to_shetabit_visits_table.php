<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('visitor.table_name', 'shetabit_visits');

        if (! Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->index(
                'created_at',
                'laravisitors_created_at_index'
            );
        });
    }

    public function down(): void
    {
        $tableName = config('visitor.table_name', 'shetabit_visits');

        if (! Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropIndex('laravisitors_created_at_index');
        });
    }
};