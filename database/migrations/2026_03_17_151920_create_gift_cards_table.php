<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('design'); // slug de diseño: 'gold', 'rose', 'sage', 'navy'
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('gift_cards'); }
};