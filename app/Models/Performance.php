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
        'act_kindness',
        'notebook',
        'total',
        'created_at',
        'updated_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function weekModel()
    {
        return $this->belongsTo(Week::class, 'week');
    }



 


}
