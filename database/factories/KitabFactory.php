<?php

namespace Database\Factories;

use App\Models\Kitab;
use App\Models\Rombel;
use Illuminate\Database\Eloquent\Factories\Factory;

class KitabFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kitab::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rombel_id' => function () {
                return Rombel::factory()->create()->id;
            },
            'mata_pelajaran' => $this->faker->randomElement(['Pendidikan Agama Islam', 'Pendidikan Agama Kristen', 'Pendidikan Agama Katolik', 'Pendidikan Agama Hindu', 'Pendidikan Agama Buddha', 'Pendidikan Agama Konghucu']),
            'nama_kitab' => $this->faker->sentence(),
            'keterangan' => $this->faker->paragraph(),
        ];
    }
}
