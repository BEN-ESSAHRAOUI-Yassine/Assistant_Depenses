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
        Schema::create('recu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->longText('texte_source');
            //$table->enum('statut', ['en_attente','traite','echoue'])->default('en_attente');
            $table->string('statut')->default('en_attente');
            $table->json('payload_brut')->nullable();
            $table->decimal('estimated_total',10, 2);
            $table->string('currency')->nullable()->default('MAD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recu');
    }
};
