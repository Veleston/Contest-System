<?php

// app/Models/Contest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'access_level',
        'start_time',
        'end_time',
        'prize_amount',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'prize_amount' => 'float',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function participations(): HasMany
    {
        return $this->hasMany(ContestParticipation::class);
    }

    public function prize(): BelongsToMany
    {
        return $this->belongsToMany(Prize::class);
    }

    public function isAccessibleBy(User $user): bool
    {
        return $user->role === 'VIP' || 
               ($user->role === 'SIGNED_IN' && $this->access_level === 'NORMAL');
    }

    public function isInProgress(): bool
    {
        return now()->between($this->start_time, $this->end_time);
    }
}
