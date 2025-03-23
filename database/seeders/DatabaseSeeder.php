<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    use WithoutModelEvents;

    public function run()
    {
        // Seed users with different roles
        $this->callWith(UserSeeder::class, [
            'count' => 10,
            'roles' => ['ADMIN','VIP', 'SIGNED_IN', 'GUEST']
        ]);

        // Seed contests
        $this->callWith(ContestSeeder::class, [
            'count' => 5,
            'types' => ['ADMIN','NORMAL', 'VIP']
        ]);

        // Seed questions and answers for each contest
        $this->call(QuestionSeeder::class);

        // Seed contest participations
        $this->call(ContestParticipationSeeder::class);

        // Seed prizes
        $this->call(PrizeSeeder::class);
    }
}
