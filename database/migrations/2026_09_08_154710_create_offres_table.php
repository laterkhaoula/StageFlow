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
        Schema::create('offres', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profil_entreprise_id')
                ->constrained('company_profiles')
                ->cascadeOnDelete();

            $table->string('titre');
            $table->text('description');
            $table->string('domaine');
            $table->string('localisation');
            $table->date('date_publication');
            $table->string('statut');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};