<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Contest;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contests = Contest::all();
        
        foreach ($contests as $contest) {
            // Create 5 questions per contest
            for ($i = 0; $i < 5; $i++) {
                $question = Question::create([
                    'contest_id' => $contest->id,
                    'content' => "Question " . ($i + 1) . " for Contest " . $contest->id,
                    'question_type' => $this->getRandomQuestionType(),
                    'points' => rand(1, 5),
                ]);

                // Create answers for the question
                $this->createAnswers($question);
            }
        }
    }

    private function getRandomQuestionType()
    {
        $types = ['single_select', 'multi_select', 'true_false'];
        return $types[array_rand($types)];
    }

    private function createAnswers($question)
    {
        $answers = [];
        $correctCount = $question->question_type === 'multi_select' ? rand(1, 3) : 1;
        
        for ($i = 0; $i < 4; $i++) {
            $answers[] = [
                'question_id' => $question->id,
                'content' => "Answer " . ($i + 1),
                'is_correct' => $i < $correctCount,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Answer::insert($answers);
    }
}
