<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('collection_points', function (Blueprint $table) {
            if (!Schema::hasColumn('collection_points', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('collection_points', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }
        });
    }


    public function down()
    {
        Schema::table('collection_points', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }

};
