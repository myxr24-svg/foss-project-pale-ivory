<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = ['name', 'capacity'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
