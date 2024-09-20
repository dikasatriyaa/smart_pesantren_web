<?php

namespace Database\Factories;

use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Rombel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mapel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'guru_id' => function () {
                return Guru::factory()->create()->id;
            },
            'rombel_id' => function () {
                return Rombel::factory()->create()->id;
            },
            'mata_pelajaran' => $this->faker->randomElement(['Matematika', 'Bahasa Indonesia', 'Fisika', 'Kimia']),
        ];
    }
}
