<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array=['video', 'image', 'record','text'];
        return [
            'con_id' =>rand(1000000,1000005),
            'content' =>$this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'user_id' =>rand(1000000,1000005),
            'type' =>$array[rand(0,3)]

        ];
    }
}
