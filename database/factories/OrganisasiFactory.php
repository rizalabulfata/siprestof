<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganisasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kodifikasi_id' => null,
            'mahasiswa_id' => null,
            'name' => fake()->company,
            'year_start' => fake()->numberBetween(2010, 2020),
            'year_end' => fake()->numberBetween(2010, 2020),
            'sk_number' => fake()->uuid,
            'certificate' => json_encode([
                ['name' => 'fake/certificate.jpg'],
                ['name' => 'fake/dummy.pdf']
            ])
        ];
    }
}
