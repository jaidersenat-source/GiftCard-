<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\GiftCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Admin user (idempotente)
        User::updateOrCreate(
            ['email' => 'admin@giftcard.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Productos de ejemplo
        Product::insert([
            ['name' => 'Caja de Chocolates Premium', 'product_code' => 'PROD-CHOCO001', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ramo de Rosas Rojas',         'product_code' => 'PROD-ROSA001',  'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vino Tinto Reserva',           'product_code' => 'PROD-VINO001',  'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Plantillas de tarjetas
        GiftCard::insert([
            ['title' => 'Elegancia Dorada',   'design' => 'gold',  'description' => 'Para ocasiones especiales con toque de lujo.', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Amor en Rosa',        'design' => 'rose',  'description' => 'Perfecta para expresar amor y cariño.',         'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Serenidad Natural',   'design' => 'sage',  'description' => 'Para un regalo lleno de paz y naturaleza.',     'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Noche Azul',          'design' => 'navy',  'description' => 'Sofisticada y misteriosa.',                     'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}