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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
    $table->string('prenom');
    $table->string('nom');
    $table->string('email')->unique();
    $table->string('telephone')->nullable();
    $table->date('date_naissance')->nullable();
    $table->string('nationalite')->nullable();
    $table->enum('piece_identite', ['CNI', 'passeport', 'permis'])->nullable();
    $table->string('numero_piece')->nullable();
    $table->text('adresse')->nullable();
    $table->string('avatar')->nullable();
    $table->enum('statut', ['actif', 'inactif'])->default('actif');
    $table->string('mot_de_passe');
    $table->enum('sexe', ['homme', 'femme'])->nullable();
    $table->timestamp('email_verified_at')->nullable();
    $table->rememberToken();
    $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
