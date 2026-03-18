// database/migrations/xxxx_create_gifts_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('gift_card_id')->constrained()->cascadeOnDelete();
            $table->string('recipient_name');
            $table->text('message');
            $table->string('access_key')->unique(); // palabra clave personalizada
            $table->string('unique_code');           // código de sesión de escaneo
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('gifts'); }
};