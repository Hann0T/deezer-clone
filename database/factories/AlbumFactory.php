<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'upc' => $this->faker->numberBetween(),
            'cover' => $this->faker->imageUrl(),
            'artist_id' => \App\Models\Artist::factory()->create()->id,
        ];
    }
}
