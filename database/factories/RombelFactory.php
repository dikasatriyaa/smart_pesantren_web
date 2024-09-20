<?php

namespace Database\Factories;

use App\Models\Rombel;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class RombelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rombel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tahun_pelajaran' => $this->faker->randomElement(['2022/2023', '2023/2024', '2024/2025']),
            'tingkat_kelas' => $this->faker->randomElement(['X', 'XI', 'XII']),
            'nama_rombel' => $this->faker->unique()->randomElement(['IPA 1', 'IPS 2', 'Bahasa 3']),
            'guru_id' => function () {
                return Guru::factory()->create()->id;
            },
        ];
    }
}
