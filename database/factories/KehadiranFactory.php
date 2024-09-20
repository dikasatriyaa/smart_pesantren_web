<?php

namespace Database\Factories;

use App\Models\Kehadiran;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class KehadiranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kehadiran::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'santri_id' => function () {
                return Santri::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['Hadir', 'Izin', 'Sakit', 'Alpha']),
            'masuk' => $this->faker->time('H:i:s', 'now'),
            'tanggal' => $this->faker->date(),
        ];
    }
}
