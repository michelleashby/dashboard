<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //Email class is used for the correspondance that will be stored and sent out to contacts
    /**
     * @var string
     */

//    # EMAIL
//$smtpServer = 'smtp.office365.com'
//$smtpUser = 'sa_mail@brentwood.bc.ca'
//$smtpPassword = '5PbiTcQhHlpq1qjPRv4m'
//$emailFrom = "Brentwood College School <welcome@brentwood.bc.ca>"

    protected $connection = 'mysql';

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
        return $this->hasOne('App\Step', 'email_id');
    }
}