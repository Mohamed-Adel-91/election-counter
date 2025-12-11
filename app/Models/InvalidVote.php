<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvalidVote extends Model
{
    protected $fillable = [
        'count',
    ];
}
