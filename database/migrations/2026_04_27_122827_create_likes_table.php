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
    Schema::create('likes', function (Blueprint $table) {
        $table->id();
        // ID dell'utente che mette il like
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // ID del post che riceve il like
        $table->foreignId('post_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        // SICUREZZA: Impedisce allo stesso utente di mettere più di un like allo stesso post
        $table->unique(['user_id', 'post_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
