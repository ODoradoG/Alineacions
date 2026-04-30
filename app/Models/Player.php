<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
    ];

    public function lineups()
    {
        return $this->belongsToMany(Lineup::class)->withPivot('position')->withTimestamps();
    }
}
