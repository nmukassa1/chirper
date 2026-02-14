<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    // Defines what columns can be assigned a value in the DB
    protected $fillable = [
        'message',
    ];

    // Defines the relationship between the Chirp and User models
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
