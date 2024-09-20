<?php

namespace Database\Factories;

use App\Models\Pelanggaran;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelanggaranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pelanggaran::class;

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
            'pelanggaran' => $this->faker->sentence(),
            'tindakan' => $this->faker->sentence(),
            'tanggal' => $this->faker->date(),
        ];
    }
}
