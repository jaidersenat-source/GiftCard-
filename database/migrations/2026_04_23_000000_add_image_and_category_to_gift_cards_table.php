<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('gift_cards', function (Blueprint $table) {
            if (! Schema::hasColumn('gift_cards', 'image_path')) {
                $table->string('image_path')->nullable()->after('design');
            }
            if (! Schema::hasColumn('gift_cards', 'category')) {
                $table->string('category')->default('general')->after('image_path');
            }
        });
    }

    public function down(): void {
        Schema::table('gift_cards', function (Blueprint $table) {
            if (Schema::hasColumn('gift_cards', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (Schema::hasColumn('gift_cards', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
