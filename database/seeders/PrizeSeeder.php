<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prize;
use App\Models\User;
use App\Models\Contest;
use App\Models\ContestParticipation;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $contests = Contest::all();

        foreach ($contests as $contest) {
            // Award prize to a random user who participated and completed the contest
            $winner = ContestParticipation::where([
                'contest_id' => $contest->id,
                'completed' => true,
            ])
            ->orderBy('score', 'desc')
            ->first();

            if ($winner) {
                Prize::create([
                    'name' => "Winner of " . $contest->name,
                    'amount' => $contest->prize_amount,
                    'user_id' => $winner->user_id,
                    'contest_id' => $contest->id,
                    'awarded_at' => now()->subDays(rand(1, 7)),
                ]);
            }
        }
    }
}
