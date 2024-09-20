<?php

namespace Database\Factories;

use App\Models\Hafalan;
use Illuminate\Database\Eloquent\Factories\Factory;

class HafalanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hafalan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'santri_id' => function () {
                return \App\Models\Santri::factory()->create()->id;
            },
            'guru_id' => function () {
                return \App\Models\Guru::factory()->create()->id;
            },
            'juz' => $this->faker->numberBetween(1, 30),
            'progres' => $this->faker->randomElement(['50%', '75%', '100%']),
            'catatan' => $this->faker->text(100),
        ];
    }
}
