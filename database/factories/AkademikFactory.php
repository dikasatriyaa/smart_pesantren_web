<?php

namespace Database\Factories;

use App\Models\Akademik;
use App\Models\Santri;
use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AkademikFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Akademik::class;

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
            'mapel_id' => function () {
                return Mapel::factory()->create()->id;
            },
            'tahun_pelajaran' => $this->faker->randomElement(['2023/2024', '2022/2023', '2021/2022']),
            'nilai' => $this->faker->randomFloat(2, 60, 100), // Contoh nilai acak antara 60-100
        ];
    }
}
