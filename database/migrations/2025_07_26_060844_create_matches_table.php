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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('status_rounds_id')
                ->constrained('status_rounds')
                ->onDelete('restrict');

            $table->foreignId('home_team_id')
                ->constrained('teams')
                ->onDelete('restrict');

            $table->foreignId('away_team_id')
                ->constrained('teams')
                ->onDelete('restrict');
            
            $table->integer('home_gols');
            $table->integer('away_gols');

            $table->integer('winner')->nullable();

            $table->integer('round_number');
            $table->date('date_matche');
            
            $table->foreignId('status_matches_id')
                ->constrained('status_matches')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
