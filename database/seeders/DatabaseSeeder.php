<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,  // 1. Primero las categorías (sin dependencias)
            UserSeeder::class,      // 2. Luego los usuarios
            ProductSeeder::class,   // 3. Finalmente los productos (dependen de usuarios y categorías)
        ]);

        $this->command->info('');
        $this->command->info('🎉 ¡Base de datos de ReWear poblada exitosamente!');
        $this->command->info('');
        $this->command->info('📧 Cuentas de demostración:');
        $this->command->table(
            ['Rol', 'Email', 'Contraseña'],
            [
                ['Administrador', 'admin@rewear.com',      'password'],
                ['Vendedor',      'vendedor@rewear.com',   'password'],
                ['Comprador',     'comprador@rewear.com',  'password'],
            ]
        );
    }
}
