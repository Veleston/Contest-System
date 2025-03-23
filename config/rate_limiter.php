<?php

return [
    'auth' => [
        'max_attempts' => 5,
        'decay_minutes' => 1,
    ],
    'contests' => [
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],
    'participations' => [
        'max_attempts' => 30,
        'decay_minutes' => 1,
    ],
    'leaderboard' => [
        'max_attempts' => 100,
        'decay_minutes' => 1,
    ],
    'prizes' => [
        'max_attempts' => 100,
        'decay_minutes' => 1,
    ],
];