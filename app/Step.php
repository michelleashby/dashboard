<?php
/**
 * Created by PhpStorm.
 * User: michelle.ashby
 * Date: 2/20/18
 * Time: 11:35 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomCollection;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class Step extends Model
{
    //This model is going to be used for the steps that students step through during admissions process
    //They have one button per student associated with each step
    //Button holds class and words where as the step will have questionnaire_id and email_id


    protected $connection = 'mysql';

    /**
     * @var string
     */
    protected $table = 'step';

    /**
     * @var string
     */
    protected $primaryKey = 'step_id';

    /**
     * Creates a hasMANY relationship between steps->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function button(){
        return $this->hasMany('App\Button', 'step_id');
    }

    public function email(){
        return $this->hasOne('App\Email', 'email_id');
    }

}