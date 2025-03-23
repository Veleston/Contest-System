<?php

// app/Models/Prize.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'user_id',
        'contest_id',
        'awarded_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'awarded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
