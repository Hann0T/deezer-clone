<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'title_short' => $this->faker->title(),
            'duration' => $this->faker->numberBetween(0, 14),
            'rank' => $this->faker->numberBetween(),
            'track_position' => $this->faker->numberBetween(1, 50),
            'album_id' => \App\Models\Album::factory()->create()->id
        ];
    }
}
