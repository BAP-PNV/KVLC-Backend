<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FriendRelationship>
 */
class FriendRelationshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'id'=>rand(1,5),
                'user_id' => rand(1000000,1000009),
                'is_blocked' => fake()->boolean()
        ];
    }
}
