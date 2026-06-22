<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ronde extends Model
{
    protected $table = 'rondes';

    protected $fillable = [
        'spel_id',
        'speler_id',
        'zet_id',
        'ronde_nummer',
        'ronde_uitkomst',
    ];

    public function spel()
    {
        return $this->belongsTo(Spel::class, 'spel_id');
    }

    public function speler()
    {
        return $this->belongsTo(User::class, 'speler_id');
    }

    public function zet()
    {
        return $this->belongsTo(Zet::class, 'zet_id');
    }
}