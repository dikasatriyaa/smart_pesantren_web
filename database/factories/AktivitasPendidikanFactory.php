<?php

namespace Database\Factories;

use App\Models\AktivitasPendidikan;
use App\Models\Santri;
use App\Models\Rombel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AktivitasPendidikanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AktivitasPendidikan::class;

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
            'rombel_id' => function () {
                return Rombel::factory()->create()->id;
            },
            'tahun_pelajaran' => $this->faker->randomElement(['2023/2024', '2022/2023', '2021/2022']),
        ];
    }
}
