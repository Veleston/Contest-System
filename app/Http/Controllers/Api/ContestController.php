<?php

// app/Http/Controllers/Api/ContestController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $contests = Contest::when(
            !$user || $user->role === 'GUEST',
            fn($q) => $q->where('access_level', 'NORMAL')
        )->when(
            $user && $user->role !== 'VIP',
            fn($q) => $q->where('access_level', 'NORMAL')
        )
        ->with('questions')
        ->get();

        return response()->json($contests);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'access_level' => 'required|in:ADMIN,NORMAL,VIP',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'prize_amount' => 'required|numeric',
            'questions' => 'required|array',
            'questions.*.content' => 'required|string',
            'questions.*.question_type' => 'required|in:single_select,multi_select,true_false',
            'questions.*.points' => 'required|numeric',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.content' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        $contest = Contest::create($validatedData);

        foreach ($validatedData['questions'] as $questionData) {
            $question = $contest->questions()->create([
                'content' => $questionData['content'],
                'question_type' => $questionData['question_type'],
                'points' => $questionData['points'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $question->answers()->create([
                    'content' => $answerData['content'],
                    'is_correct' => $answerData['is_correct'],
                ]);
            }
        }

        return response()->json($contest, 201);
    }

    public function show(Contest $contest)
    {
        return response()->json($contest->load('questions.answers'));
    }

    public function update(Request $request, Contest $contest)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'access_level' => 'nullable|in:ADMIN,NORMAL,VIP',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'prize_amount' => 'nullable|numeric',
        ]);

        $contest->update($validatedData);

        return response()->json($contest);
    }

    public function destroy(Contest $contest)
    {
        $contest->delete();
        return response()->json(['message' => 'Contest deleted successfully']);
    }
}
