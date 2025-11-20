<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'matric_number',
        'email',
        'phone_number',
        'department',
        'level',
        'trade_id',
    ];

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }
}
