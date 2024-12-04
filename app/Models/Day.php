<?php

namespace App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Day extends Model
{
    use HasFactory;


    public function group() {
        return $this->belongsTo(Group::class);
    }
//propriete de laravel
//utiliser pour proteger les attributs contre la assignation en masse non desirer
    protected $fillable = [
        "day",
        'start_time',
        'end_time',
        'group_id'
    ];

}
