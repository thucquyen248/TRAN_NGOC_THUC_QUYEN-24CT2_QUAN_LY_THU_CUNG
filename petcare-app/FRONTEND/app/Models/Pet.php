<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'species', 'age', 'owner_id'];

    // Quan hệ với Owner
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    // Quan hệ với Appointment
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
