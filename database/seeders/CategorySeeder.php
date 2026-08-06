<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() > 0) {
            return;
        }

        $categories = [
            [
                'name'     => 'Mujer',
                'icon'     => 'bx bx-female',
                'children' => [
                    'Vestidos y faldas',
                    'Tops y camisetas',
                    'Blusas',
                    'Pantalones y jeans',
                    'Suéteres y abrigos',
                    'Chamarras',
                    'Ropa deportiva',
                    'Ropa interior y lencería',
                    'Trajes de baño',
                    'Pijamas',
                ],
            ],
            [
                'name'     => 'Hombre',
                'icon'     => 'bx bx-male',
                'children' => [
                    'Camisetas y polos',
                    'Camisas',
                    'Pantalones y jeans',
                    'Shorts',
                    'Suéteres y sudaderas',
                    'Chamarras y abrigos',
                    'Ropa deportiva',
                    'Ropa interior',
                    'Trajes y blazers',
                    'Pijamas',
                ],
            ],
            [
                'name'     => 'Niños',
                'icon'     => 'bx bx-child',
                'children' => [
                    'Bebé (0-24 meses)',
                    'Niña (2-12 años)',
                    'Niño (2-12 años)',
                    'Adolescentes',
                    'Uniformes escolares',
                ],
            ],
            [
                'name'     => 'Accesorios',
                'icon'     => 'bx bx-diamond',
                'children' => [
                    'Bolsas y carteras',
                    'Cinturones',
                    'Gorras y sombreros',
                    'Joyería',
                    'Bufandas y pañuelos',
                    'Lentes',
                ],
            ],
            [
                'name'     => 'Calzado',
                'icon'     => 'bx bx-walk',
                'children' => [
                    'Zapatos de mujer',
                    'Zapatos de hombre',
                    'Tenis',
                    'Botas',
                    'Sandalias',
                    'Zapatos de niños',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create([
                'name'      => $categoryData['name'],
                'slug'      => Str::slug($categoryData['name']),
                'icon'      => $categoryData['icon'],
                'parent_id' => null,
            ]);

            foreach ($categoryData['children'] as $childName) {
                // Prefix with parent name to ensure uniqueness (DB has unique constraint on name)
                $uniqueName = $categoryData['name'] . ' — ' . $childName;
                Category::create([
                    'name'      => $uniqueName,
                    'slug'      => Str::slug($categoryData['name'] . '-' . $childName),
                    'icon'      => $categoryData['icon'],
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
