<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    protected $table = 'schoolsessions';
    
    protected $fillable = [
        'title',
    ];

}
