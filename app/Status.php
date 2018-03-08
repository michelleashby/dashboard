<?php
/**
 * Created by PhpStorm.
 * User: michelle.ashby
 * Date: 8/14/17
 * Time: 3:56 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class Status extends Model
{
    protected $connection = ‘mysql’;


    // This class is for statuses
    // Button have one status
    /**
     * @var string
     */
    protected $table = 'questionnaire_status';

    /**
     * @var string
     */
    protected $primaryKey = 'questionnaire_submission_id';

    /**
     * Creates a hasMany relationship between student->buttons
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function button(){
        return $this->belongsTo('App\Button', 'button_id');
    }
}