<?php

namespace Database\Factories;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Santri::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'nisn' => $this->faker->unique()->numerify('##########'),
            'no_kk' => $this->faker->unique()->numerify('############'),
            'nik' => $this->faker->unique()->numerify('############'),
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'anak_ke' => $this->faker->numberBetween(1, 10),
            'hobi' => $this->faker->randomElement(['Sepak bola', 'Renang', 'Basket', 'Berkebun']),
            'nomor_kip' => $this->faker->unique()->numerify('##############'),
        ];
    }
}
