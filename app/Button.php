<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomCollection;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class Button extends Model
{
    //This model is going to be used for the buttons shown next to students
    //Trying to make them a customCollection object through the override appearing here first
    //They basically control all functionality of the Dashboard
    //They will have a single student  per button but many buttons per student
    //They will also be dynamically colored and generated based on form/db information

//    public function newCollection(array $models = [])
//    {
//        return new CustomCollection($models);
//    }

    /**
     * @var string
     */
    protected $table = 'button';

    /**
     * @var string
     */
    protected $primaryKey = 'button_id';

    /**
     * Creates a hasOne relationship between student->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student(){
        return $this->hasOne('App\Student', 'user_id');
    }

    public function email(){
        return $this->hasMany('App\Email','email_id' );
        //hasMany as there is a boolean column in button_email
        //this is called 'switch' and can be used to have a single email as the active one
        //built in historical information
    }

}
