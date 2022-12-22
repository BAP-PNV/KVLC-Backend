<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // import database user
        \App\Models\User::factory(10)->create();
        // import database friendrelationship

        \App\Models\FriendRelationship::factory(10)->create();
        // import database conversation
        \App\Models\Conversation::factory(10)->create();
         // import database message
         \App\Models\Message::factory(10)->create();

        // import database memberofconversation
         \App\Models\MembersOfConversation::factory(10)->create();
    }
}
