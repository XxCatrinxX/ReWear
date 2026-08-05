<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Conditions map (must match migration enum values).
     */
    private array $conditions = [
        'nuevo',
        'como_nuevo',
        'bueno',
        'aceptable',
    ];

    private array $brands = [
        'Zara', 'H&M', 'Mango', 'Levi\'s', 'Nike', 'Adidas', 'Pull&Bear',
        'Stradivarius', 'Bershka', 'Forever 21', 'Shein', 'Genérico',
        'Ralph Lauren', 'Tommy Hilfiger', 'Calvin Klein',
    ];

    private array $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '36', '38', '40', '42', '44'];

    private array $colors = [
        'Negro', 'Blanco', 'Gris', 'Azul', 'Verde', 'Rojo', 'Beige',
        'Café', 'Rosa', 'Morado', 'Amarillo', 'Naranja',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Chamarra de mezclilla vintage',
            'Suéter de punto acanalado',
            'Vestido floral de verano',
            'Pantalón chino slim fit',
            'Camiseta básica de algodón',
            'Blusa de seda estampada',
            'Abrigo largo de lana',
            'Shorts de mezclilla',
            'Falda midi plisada',
            'Jogger cargo holgado',
            'Top deportivo sin mangas',
            'Camisa oxford de cuadros',
            'Turtleneck de punto fino',
            'Overol de mezclilla completo',
        ];

        return [
            'user_id'     => User::factory()->seller(),
            'category_id' => Category::inRandomOrder()->value('id') ?? 1,
            'title'       => $this->faker->randomElement($titles) . ' ' . $this->faker->randomElement($this->brands),
            'description' => $this->faker->paragraphs(2, true),
            'price'       => $this->faker->randomFloat(2, 50, 1500),
            'stock'       => $this->faker->numberBetween(1, 5),
            'condition'   => $this->faker->randomElement($this->conditions),
            'brand'       => $this->faker->randomElement($this->brands),
            'size'        => $this->faker->randomElement($this->sizes),
            'color'       => $this->faker->randomElement($this->colors),
            'is_active'   => true,
            'is_sold'     => false,
        ];
    }

    /**
     * Indicate the product is sold out.
     */
    public function sold(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_sold'   => true,
            'is_active' => false,
            'stock'     => 0,
        ]);
    }

    /**
     * Indicate the product is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
