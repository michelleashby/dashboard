<?php
/**
 * Created by PhpStorm.
 * User: michelle.ashby
 * Date: 7/31/17
 * Time: 2:52 PM
 */

namespace App\Http\Controllers;


use App\Button;
use App\Email;
use App\Step;
use App\Student;
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
    //all send functions require a email to be passed so that it can be mailed
    // Bleu health and enrolment require their own functions but other emails can be sent via linked email id
    public function sendLocalEnrol($email)
    {

    }

    public function resendLocalEnrol($email)
    {

    }

    public function sendCanEnrol($email)
    {

    }

    public function resendCanEnrol($email)
    {

    }

    public function sendUSEnrol($email)
    {

    }

    public function resendUSEnrol($email)
    {

    }

    public function sendIntEnrol($email)
    {

    }

    public function resendIntEnrol($email)
    {

    }

    public function sendHealth($email)
    {
        //API call will know/deal with send or resend once Mike completes dev of this feature


    }

    public function resendHealth($email)
    {
        //API call will know/deal with send or resend once Mike completes dev of this feature


    }

    public function sendEmail($bid)
    {

    }

    public function resendEmail($bid)
    {

    }

    public function onClick($bid){
        $buttonID = $bid;
//        for testing:
//        Return "route works " . $buttonID;

        $button = Button::find($buttonID);
        $student = $button->student();

        $step = Step::find($button->step_id);

        //status codes: 0 not sent, 1 sent but not complete, 2 complete

        //have to figure out which email to send based on type
        if($step->email_id == null) {
            return "no email associated with this button - please contact Helpdesk and let them know. " .
                "<br><a href='/home'>Back to Home</a>";
        } elseif($step->email_id == 0) {  //enrolment email should be id of 0
            if ($button->status_id == 0) { // 0 = not sent
                if ($student->student_type = "Canadian BC") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";
                    //send initial email
                    $parents = $student->contact();

                    foreach($parents as $parent){
                        if($parent->parent_email != null) {
                            $this->sendLocalEnrol($parent->parent_email);
                        }
                    }

                    //change button status to 1 sent but not complete

                    //add to questionnaire in MySchool using API


                } elseif ($student->student_type = "Canadian Boarding") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";

                } elseif ($student->student_type = "US Boarding") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";

                } elseif ($student->student_type = "International Boarding") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";

                } else {
                    return "Student Type of " . $student->student_type . " not recognised" .
                        "<br><a href='/home'>Back to Home</a>";
                }
            } elseif ($button->status_id == 1) { // 1 = sent but not complete
                if ($student->student_type = "Canadian BC") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";
                    //send reminder email
                    $parents = $student->contact();

                    foreach($parents as $parent){
                        if($parent->parent_email != null) {
                            $this->resendLocalEnrol($parent->parent_email);
                        }
                    }

                } elseif ($student->student_type = "Canadian Boarding") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";

                } elseif ($student->student_type = "US Boarding") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";

                } elseif ($student->student_type = "International Boarding") {
                    return "route works - got to " . $student->student_type .
                        "<br><a href='/home'>Back to Home</a>";

                } else {
                    return "Student Type of " . $student->student_type . " not recognised" .
                        "<br><a href='/home'>Back to Home</a>";
                }
            }
        }elseif($step->email()->email_name = "bluehealth") {
            //API call for bluehealth

        } else {
            if($button->status_id == 0) { //0 = not sent
                //send email
                $parents = $student->contact();

                foreach($parents as $parent) {
                    if ($parent->parent_email != null) {
                        $this->sendEmail($button->button_id);
                    }
                }
                // add to questionnaire

                //change button status
                $button->status_id = 1;
                $button->save();

            } elseif($button->status_id == 1){ //1 = sent but not complete
                //send reminder email
                $parents = $student->contact();

                foreach ($parents as $parent) {
                    if ($parent->parent_email != null) {
                        $this->sendEmail($button->button_id);
                    }
                }
            }


            //API call function
            return "route works but logic is not";

        }



    }


}