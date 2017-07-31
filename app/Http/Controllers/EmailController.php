<?php
/**
 * Created by PhpStorm.
 * User: michelle.ashby
 * Date: 7/31/17
 * Time: 2:52 PM
 */

namespace App\Http\Controllers;


class EmailController extends Controller
{
    // this controller is used for all the email functions
    // email has email_id, email_name, button_id, type, body, active, create_at & updated_at

    public function getEmails(){
        //get all email and return names & id for use in UI

    }

    public function createEmail(){
        // saves a new email to DB

    }

    public function editEmail(){
        // saves an email after editing

    }

}