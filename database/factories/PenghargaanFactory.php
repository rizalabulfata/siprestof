<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PenghargaanFactory extends Factory
{
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
            'institution' => fake()->company,
            'date' => fake()->date(),
            'certificate' => json_encode([
                ['name' => 'certificate.jpg'],
                ['name' => 'dummy.pdf']
            ])
        ];
    }
}
