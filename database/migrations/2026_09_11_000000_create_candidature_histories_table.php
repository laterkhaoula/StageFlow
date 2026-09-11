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
        Schema::create('candidature_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidature_id')
                ->constrained('candidatures')
                ->cascadeOnDelete();

            $table->string('ancien_statut');
            $table->string('nouveau_statut');
            $table->timestamp('date_changement')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidature_histories');
    }
};
