<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Ajoutez seulement les colonnes qui n'existent pas
            if (!Schema::hasColumn('events', 'average_rating')) {
                $table->decimal('average_rating', 3, 2)->default(0);
            }
            
            if (!Schema::hasColumn('events', 'rating_count')) {
                $table->integer('rating_count')->default(0);
            }
            
            if (!Schema::hasColumn('events', 'positive_feedbacks')) {
                $table->integer('positive_feedbacks')->default(0);
            }
            
            if (!Schema::hasColumn('events', 'negative_feedbacks')) {
                $table->integer('negative_feedbacks')->default(0);
            }
            
            if (!Schema::hasColumn('events', 'neutral_feedbacks')) {
                $table->integer('neutral_feedbacks')->default(0);
            }
            
            if (!Schema::hasColumn('events', 'last_feedback_at')) {
                $table->timestamp('last_feedback_at')->nullable();
            }
        });

        // Pour la table participations
        Schema::table('participations', function (Blueprint $table) {
            if (!Schema::hasColumn('participations', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down()
    {
        // Pas besoin de rollback pour cette migration de correction
    }
};