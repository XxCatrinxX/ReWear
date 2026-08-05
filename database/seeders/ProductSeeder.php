<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Product titles organized by category keyword.
     */
    private array $productData = [
        // Generic items for all categories
        'Vestido floral midi vintage muy buen estado',
        'Chamarra de mezclilla Levi\'s 501 azul talla M',
        'Blusa de seda estampada multicolor S/M nueva sin etiqueta',
        'Pantalón cargo holgado verde olivo talla L',
        'Suéter de punto grueso acanalado beige talla S',
        'Abrigo largo oversized gris perla talla M',
        'Falda plisada metalizada plata XS',
        'Camiseta básica blanca pack de 3 talla XL',
        'Jogger deportivo negro slim fit Nike talla M',
        'Top halter crochet verano blanco talla S',
        'Camisa oxford cuadros Zara Man azul talla L',
        'Shorts de mezclilla Mom jeans cortos talla 28',
        'Vestido lencero satinado verde botella talla M',
        'Hoodie oversized gris melange Champion talla L',
        'Conjunto deportivo Adidas lila claro talla S',
        'Traje de baño enterizo negro con cut-outs talla M',
        'Blazer estructurado camel vintage talla M',
        'Turtleneck lana merino azul marino talla S',
        'Overall mezclilla completo Wrangler talla 32',
        'Crop top manga larga rayas marineras XS',
        'Jeans boyfriend destroyed talla 27',
        'Parka impermeable verde militar talla L',
        'Minifalda plisada rosa pastel talla XS',
        'Camisa hawaiana floral colorida talla M',
        'Leggings de cuero sintético negro talla M',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = User::where('is_seller', true)->get();
        $categories = Category::all();

        if ($sellers->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('⚠️ No hay vendedores o categorías disponibles. Ejecuta UserSeeder y CategorySeeder primero.');
            return;
        }

        $conditions = [
            'nuevo',
            'como_nuevo',
            'bueno',
            'aceptable',
        ];

        $brands = [
            'Zara', 'H&M', 'Mango', 'Levi\'s', 'Nike', 'Adidas', 'Pull&Bear',
            'Stradivarius', 'Bershka', 'Forever 21', 'Genérico',
            'Ralph Lauren', 'Tommy Hilfiger', 'Calvin Klein',
        ];

        $sizes  = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '26', '27', '28', '30', '32', '34'];
        $colors = ['Negro', 'Blanco', 'Gris', 'Azul', 'Verde', 'Rojo', 'Beige', 'Café', 'Rosa'];

        foreach ($this->productData as $index => $title) {
            $seller   = $sellers->random();
            $category = $categories->random();

            Product::create([
                'user_id'     => $seller->id,
                'category_id' => $category->id,
                'title'       => $title,
                'description' => 'Prenda en excelente estado. Comprada hace tiempo y apenas usada. Se vende porque ya no la uso. Las medidas son aproximadas, por favor revisar la tabla de tallas. Acepto preguntas. Envío a todo el país.',
                'price'       => fake()->randomFloat(2, 80, 1200),
                'stock'       => fake()->numberBetween(1, 3),
                'condition'   => fake()->randomElement($conditions),
                'brand'       => fake()->randomElement($brands),
                'size'        => fake()->randomElement($sizes),
                'color'       => fake()->randomElement($colors),
                'is_active'   => true,
                'is_sold'     => false,
            ]);
        }

        $this->command->info('✅ Productos creados: ' . count($this->productData) . ' prendas.');
    }
}
