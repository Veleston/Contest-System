<?php

// app/Http/Controllers/Api/ParticipationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestParticipation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    public function store(Request $request, Contest $contest)
    {
        $participation = ContestParticipation::create([
            'user_id' => Auth::id(),
            'contest_id' => $contest->id,
        ]);

        return response()->json($participation, 201);
    }

    public function submit(Request $request, ContestParticipation $participation)
    {
        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);

        foreach ($validatedData['answers'] as $answer) {
            $participation->userAnswers()->create([
                'answer_id' => $answer['answer_id'],
            ]);
        }

        $participation->update([
            'completed' => true,
            'submitted_at' => now(),
            'score' => $participation->calculateScore(),
        ]);

        return response()->json($participation);
    }

    public function show(ContestParticipation $participation)
    {
        return response()->json($participation->load('user', 'contest'));
    }
}