<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $connection = 'mysql';

    // This class is for the Student
    /**
     * @var string
     */
    protected $table = 'parents';

    /**
     * @var string
     */
    protected $primaryKey = 'parent_id';

    /**
     * Creates a hasMany relationship between student->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function student(){
        return $this->hasMany('App\Student', 'user_id');
    }

}
