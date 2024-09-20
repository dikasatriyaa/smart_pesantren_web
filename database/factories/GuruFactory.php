<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guru::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'gelar_depan' => $this->faker->optional()->word(),
            'gelar_belakang' => $this->faker->optional()->word(),
            'status_pegawai' => $this->faker->randomElement(['PNS', 'Honorer', 'Tetap', 'Kontrak']),
            'npk' => $this->faker->unique()->numerify('NPK#####'),
            'tmt_pegawai' => $this->faker->date,
            'npwp' => $this->faker->optional()->numerify('################'),
        ];
    }
}
