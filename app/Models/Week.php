<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = 'week';
    
    protected $fillable = [
        'from',
        'to',
        'week',
        'schoolsession_id',
    ];

    public function sessionModel()
    {
        return $this->belongsTo(SchoolSession::class, 'schoolsession_id');
    }

}
