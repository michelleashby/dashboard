<?php
/**
 * Created by PhpStorm.
 * User: michelle.ashby
 * Date: 7/31/17
 * Time: 2:52 PM
 */

namespace App\Http\Controllers;


use App\Email;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;


class EmailController extends Controller
{
    // this controller is used for all the email functions
    // email has email_id, email_name, button_id, type, body, active, create_at & updated_at


    public function getEmails(){
        //get all emails and return names & id for use in UI
        //currnetly not working
        $email = new Email();
        $emails = $email->all();

        return $emails;
    }

    public function createEmail(){
        // saves a new email to DB

        // get data posted from form
        $name = Input::get('name');
        $type = Input::get('type');
        $body = Input::get('body');

        // creates new email
        $email = new Email();
        $email->email_name = $name;
        $email->type = $type;
        $email->body = $body;
        $email->active = true;
        $email->created_at = Carbon::now();
        $email->save();

        return redirect()->action('PagesController@displayAdmin');
    }


    public function saveEmail($id){
        // saves an email after editing
        // also requires id to update correct email
        // get data posted from form
        $name = Input::get('name');
        $type = Input::get('type');
        $body = Input::get('body');
        $active = Input::get('active');

        $email = Email::find($id);

        if($type == null){
            $type = $email->type;
        }

        if($active == null){
            $active = $email->active;
        }

        //check if data has changed
        if($email->email_name != $name || $email->type != $type || $email->body != $body || $email->active != 1){
            $email->email_name = $name;
            $email->type = $type;
            $email->body = $body;
            $email->active = $active;
            $email->updated_at = Carbon::now();
            $email->update();

            return redirect()->action('PagesController@displayAdmin');
        } else {
            return "No changes detected for email" . '<br><a class="btn btn-primary btn-lg" href="/admin" role="button">Return to Admin</a>';
        }

    }

    //following 'click' button functions deal with the action if a button is clicked
    //button state will disable a click if it should not be clicked
    //all send functions require a parent id to be passed so that it can be mailed to them
    public function sendValidation($pid)
    {

    }

    public function resendValidation($pid)
    {

    }

    public function sendEnrolment($pid)
    {

    }

    public function resendEnrolment($pid)
    {

    }

    public function sendInformedConsent($pid)
    {

    }

    public function resendIC()
    {

    }

    public function sendCourseSelection()
    {

    }

    public function resendCS()
    {

    }

    public function sendHealth()
    {
        //API call will know/deal with send or resend once Mike completes dev of this feature


    }

    public function sendOrientation()
    {

    }

    public function resendOrientation()
    {

    }

    public function sendPrefect()
    {

    }

    public function resendPrefect()
    {

    }


}