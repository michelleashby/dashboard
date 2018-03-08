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
    //They will have a single student per button but many buttons per student
    //They will also be dynamically colored and generated based on form/db information
    //Button holds class and words where as the step will have questionnaire_id and email_id

//    public function newCollection(array $models = [])
//    {
//        return new CustomCollection($models);
//    }

    protected $connection = 'mysql';

    /**
     * @var string
     */
    protected $table = 'button';

    /**
     * @var string
     */
    protected $primaryKey = 'button_id';

    /**
     * Creates a belongs to relationship between student->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student(){
        return $this->belongsTo('App\Student', 'user_id');
    }

    public function step(){
        return $this->belongsTo('App\Step', 'step_id');
    }

    public function status(){
        return $this->hasOne('App\Status', 'questionnaire_submission_id', 'button_status_id');
    }

}
