<?php

namespace App\Models;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_name',
        'standard',

    ];

    /**
     * Get the marks for the student.
     */
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
