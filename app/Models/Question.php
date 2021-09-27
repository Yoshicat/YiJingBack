<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'code', 'user_id'];

    protected $casts = [
        'created_at' => 'date:d.m.Y',
    ];

}
