<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembersOfConversation>
 */
class MembersOfConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'con_id' =>rand(1000000,1000005),
            'user_id' =>rand(1000000,1000005),
            'display_name' =>fake() ->name()
        ];
    }
}
