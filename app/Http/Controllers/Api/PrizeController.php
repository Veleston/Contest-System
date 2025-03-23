<?php

// app/Http/Controllers/Api/PrizeController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrizeController extends Controller
{
    public function index()
    {
        $prizes = Prize::with('user', 'contest')
            ->when(Auth::user()->role !== 'VIP', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return response()->json($prizes);
    }

    public function show(Prize $prize)
    {
        return response()->json($prize->load('user', 'contest'));
    }
}
