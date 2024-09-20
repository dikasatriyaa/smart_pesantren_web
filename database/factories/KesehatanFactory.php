<?php

namespace Database\Factories;

use App\Models\Kesehatan;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class KesehatanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kesehatan::class;

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
            'keluhan' => $this->faker->sentence(),
            'diagnosa' => $this->faker->sentence(),
            'dokter' => $this->faker->name(),
            'obat_dikonsumsi' => $this->faker->word(),
            'obat_dokter' => $this->faker->word(),
            'tanggal_masuk' => $this->faker->date(),
            'tanggal_keluar' => $this->faker->date(),
        ];
    }
}
