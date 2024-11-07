<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Performance extends Model
{
    protected $table = 'peformance_sheet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'student_id',
        'from',
        'to',
        'class',
        'week',
        'social_behavior',
        'personal_habits',
        'created_at',
        'updated_at',
    ];


 


}
