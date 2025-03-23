<?php

// app/Models/ContestParticipation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContestParticipation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contest_id',
        'score',
        'completed',
        'submitted_at',
    ];

    protected $casts = [
        'score' => 'float',
        'completed' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function calculateScore(): float
    {
        return $this->userAnswers()
            ->join('answers', 'user_answers.answer_id', '=', 'answers.id')
            ->where('answers.is_correct', true)
            ->sum('answers.points');
    }
}
