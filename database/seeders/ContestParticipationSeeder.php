<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Contest;
use App\Models\ContestParticipation;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContestParticipationSeeder extends Seeder
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

        foreach ($users as $user) {
            // Each user participates in random contests they have access to
            $accessibleContests = $this->getAccessibleContests($user, $contests);
            
            foreach ($accessibleContests as $contest) {
                if (rand(0, 1)) { // 50% chance of participation
                    $participation = ContestParticipation::create([
                        'user_id' => $user->id,
                        'contest_id' => $contest->id,
                        'score' => rand(0, 25),
                        'completed' => rand(0, 1),
                        'submitted_at' => now()->subHours(rand(0, 48)),
                    ]);

                    // Create user answers for this participation
                    $this->createUserAnswers($participation);
                }
            }
        }
    }

    private function getAccessibleContests($user, $contests)
    {
        return $contests->filter(function ($contest) use ($user) {
            return ($user->role === 'ADMIN' || 
                    $user->role === 'VIP' || 
                    $user->role === 'SIGNED_IN' && $contest->access_level === 'NORMAL' ||
                    $user->role === 'GUEST' && $contest->access_level === 'NORMAL');
        });
    }

    private function createUserAnswers($participation)
    {
        $questions = Question::where('contest_id', $participation->contest_id)->get();
        
        foreach ($questions as $question) {
            $answers = Answer::where('question_id', $question->id)->get();
            
            if ($question->question_type === 'multi_select') {
                $selectedAnswers = $answers->random(rand(1, 3))->pluck('id')->toArray();
            } else {
                $selectedAnswers = [$answers->random()->id];
            }

            foreach ($selectedAnswers as $answerId) {
                UserAnswer::create([
                    'participation_id' => $participation->id,
                    'answer_id' => $answerId,
                ]);
            }
        }
    }
}
