<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'contact',
        'date_of_birth',
        'age',
        'gender',
        'address'
    ];

    protected $dates = [
        'date_of_birth'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
