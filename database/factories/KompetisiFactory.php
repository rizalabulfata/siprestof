<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KompetisiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Kompetisi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lomba = ['kejuaraan', 'lomba', 'ajang'];

        return [
            'kodifikasi_id' => null,
            'mahasiswa_id' => null,
            'name' => fake()->randomElement($lomba) . ' ' . fake()->country,
            'desc' => fake()->words(10, true),
            'type' => fake()->randomElement(['individu', 'tim']),
            'organizer' => fake()->company,
            'year' => fake()->numberBetween(2010, 2020),
            'documentation' => json_encode([
                ['name' => 'fake/certificate.jpg'],
                ['name' => 'fake/dummy.pdf']
            ]),
            'certificate' => json_encode([
                ['name' => 'fake/certificate.jpg'],
                ['name' => 'fake/dummy.pdf']
            ])
        ];
    }
}
