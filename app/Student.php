<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $connection = 'mysql';

    // This class is for the Student
    /**
     * @var string
     */
    protected $table = 'student';

    /**
     * @var string
     */
    protected $primaryKey = 'student_id';

    /**
     * Creates a hasMany relationship between student->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function button(){
        return $this->hasMany('App\Button', 'student_id');
    }

    public function contact(){
        return $this->hasMany('App\Contact', 'student_id');
    }

}
