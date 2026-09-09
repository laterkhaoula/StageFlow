<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profil_etudiant_id')
                ->constrained('student_profiles')
                ->cascadeOnDelete();

            $table->foreignId('offre_id')
                ->constrained('offres')
                ->cascadeOnDelete();

            $table->text('message_motivation');
            $table->date('date_candidature');
            $table->string('statut');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
