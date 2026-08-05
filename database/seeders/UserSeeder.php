<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ─── 1. Admin user ───────────────────────────────────────────────────────
        $admin = User::create([
            'name'              => 'Admin ReWear',
            'username'          => 'admin',
            'email'             => 'admin@rewear.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'is_admin'          => true,
            'is_seller'         => true,
            'status'            => true,
        ]);

        UserProfile::create([
            'user_id'    => $admin->id,
            'first_name' => 'Admin',
            'last_name'  => 'ReWear',
        ]);

        // ─── 2. Demo seller ──────────────────────────────────────────────────────
        $seller = User::create([
            'name'              => 'Sofia Vendedora',
            'username'          => 'sofiaventas',
            'email'             => 'vendedor@rewear.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'is_admin'          => false,
            'is_seller'         => true,
            'status'            => true,
        ]);

        UserProfile::create([
            'user_id'    => $seller->id,
            'first_name' => 'Sofia',
            'last_name'  => 'Martínez',
            'phone'      => '5512345678',
        ]);

        // ─── 3. Demo buyer ───────────────────────────────────────────────────────
        $buyer = User::create([
            'name'              => 'Carlos Comprador',
            'username'          => 'carloscompra',
            'email'             => 'comprador@rewear.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'is_admin'          => false,
            'is_seller'         => false,
            'status'            => true,
        ]);

        UserProfile::create([
            'user_id'    => $buyer->id,
            'first_name' => 'Carlos',
            'last_name'  => 'López',
        ]);

        // ─── 4. Random sellers (5) ───────────────────────────────────────────────
        User::factory()
            ->count(5)
            ->seller()
            ->create()
            ->each(function (User $user) {
                UserProfile::create([
                    'user_id'    => $user->id,
                    'first_name' => explode(' ', $user->name)[0],
                    'last_name'  => explode(' ', $user->name)[1] ?? '',
                ]);
            });

        // ─── 5. Random buyers (10) ───────────────────────────────────────────────
        User::factory()
            ->count(10)
            ->create()
            ->each(function (User $user) {
                UserProfile::create([
                    'user_id'    => $user->id,
                    'first_name' => explode(' ', $user->name)[0],
                    'last_name'  => explode(' ', $user->name)[1] ?? '',
                ]);
            });

        $this->command->info('✅ Usuarios creados: 1 admin, 1 vendedor demo, 1 comprador demo, 5 vendedores y 10 compradores aleatorios.');
    }
}
