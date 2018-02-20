<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //Email class is used for the correspondance that will be stored and sent out to contacts
    /**
     * @var string
     */
    protected $table = 'email';

    /**
     * @var string
     */
    protected $primaryKey = 'email_id';

    /**
     * Creates a hasOne relationship between student->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function step(){
        return $this->hasMany('App\Step', 'email_id');
    }
}