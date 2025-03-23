<?php

// app/Http/Controllers/Api/LeaderboardController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function show(Contest $contest)
    {

        $leaderboard = Contest::where('id', $contest->id)
            ->with('participations.user')
            ->first()
            ->participations()
            ->where('completed', true)
            ->orderBy('score', 'desc')
            ->paginate(10);

        return response()->json($leaderboard);
    }
}
