<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spel extends Model
{
    protected $table = 'spellen';

    protected $fillable = [
        'status',
        'gestart_op',
        'winnaar_id',
    ];

    public function spelers()
    {
        return $this->belongsToMany(User::class, 'spel_speler', 'spel_id', 'speler_id');
    }

    public function rondes()
    {
        return $this->hasMany(Ronde::class, 'spel_id');
    }

    public function winnaar()
    {
        return $this->belongsTo(User::class, 'winnaar_id');
    }
}