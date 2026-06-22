<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zet extends Model
{
    protected $table = 'zetten';

    protected $fillable = [
        'naam',
    ];
}