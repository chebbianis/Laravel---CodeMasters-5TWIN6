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
        Schema::table('users', function (Blueprint $table) {
            // Ajouter les nouveaux champs requis
            $table->string('username', 50)->unique()->after('id');
            $table->string('first_name', 50)->after('email');
            $table->string('last_name', 50)->after('first_name');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null')->after('last_name');
            $table->dateTime('last_login')->nullable()->after('role_id');
            $table->boolean('is_active')->default(true)->after('last_login');
            
            // Supprimer la colonne 'name' existante car nous avons first_name et last_name
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurer la colonne 'name'
            $table->string('name')->after('id');
            
            // Supprimer les nouveaux champs
            $table->dropColumn([
                'username',
                'first_name',
                'last_name',
                'role_id',
                'last_login',
                'is_active'
            ]);
        });
    }
};
