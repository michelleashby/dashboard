<?php

namespace App\Http\Controllers;

use App\Button;
use App\Status;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Tests\B;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Input;



class ButtonController extends Controller
{
    // Going to use this to determine the state of each button
    // and pass this information to the Pages controller to be displayed on home
    // Rules will include:
    // a DB query to check state
    // rules as to the order of completion and when things can be complete
    // href links or hooks to complete action needed for centralization

    public function editButton($id){

        $buttonName = Input::get('name');
        //$buttonEmail = Input::get('email'); //functionality to be added as we build the email form inand ability to toggle valid emails to be sent with button
        $questionnaireId = Input::get('questionnaire_id');

        $button = Button::find($id);
//        Check if name has changed
        if($button->button_name != $buttonName || $button->questionnaire_id != $questionnaireId) {
            //if input fields are not the same as the stored values for button
            //update them to be the same
            //will need to incorporate email attached here when developed
            $button->button_name = $buttonName;
            $button->questionnaire_id = $questionnaireId;

            $button->update();

        } else {
//            if nothing changed do nothing


        }

        return redirect()->action('PagesController@displayHome');
    }


    public function getStudentButtons($id){
        // returns an array of all buttons
        $button = new Button();
        $buttons = $button->where('user_id', $id)->orderBy('button_id', 'ASC')->get();

        return $buttons;
    }

    public function getButtons(){
        $button = new Button();
        $buttons = $button->all();

        return $buttons;
    }


    // buttons will be greyed out until they can be completed (btn disabled/active)
    // and then green(btn-success) when completed (btn ie.basic when active but not complete)
    // these functions query DB for current state of action for buttons' associated form
    // all set functions for buttons follow:
    public function setValidationButton($student){

        $valButton = new Button();
        $id = $student->id;
        $questionnaire = new Status();

        $questionnaires = $questionnaire->select('questionnaire_submissions.questionnaire_id',
            'questionnaire_submissions.questionnaire_submission_status_id')
            ->where('questionnaire_submissions.user_id','=',$id)
            ->get();

        if($student->custom_field_1 = "Yes") {

        $valButton->class="btn btn-success disabled";
        $valButton->words="Validation Complete  <span class=\"glyphicon glyphicon-ok\"></span>";

            return $valButton;
            }
            elseif ($questionnaires->questionnaire_id = 152 && $questionnaires->questionnaire_submission_status_id = 1) {
            // If student is in the validation questionnaire and has not completed
                $valButton->class = "btn btn-info";
                $valButton->words = "Resend Data Validation";

                $valButton->save();
            }
            else {

                $valButton->class = "btn btn-info";
                $valButton->words = "Send Data Validation";

                $valButton->save;
            }

    }

    public function setTypeButton(){
        // 3a)student type
        // NEW REQUEST from PK
        // Student type - flag if changes so it can be acknowledged
        // Considering pulling this info and setting in column here:

    }

    public function setEnrolmentButton($student){

        $enrolButton = new Button();
        $id = $student->id;
        $questionnaire = new Status();

        $questionnaires = $questionnaire->select('questionnaire_submissions.questionnaire_id',
            'questionnare_submissions.questionnaire_submission_status_id')
            ->where('questionnaire_submissions.user_id','=',$id)
            ->get();


        if($student->custom_field_2 == null){ //if questionnaires has ID of current enrollment and status of 1 invited but not complete
            $enrolButton->class="btn btn-info enabled";
            $enrolButton->words="Resend enrolment reminder";

            return $enrolButton;
        } elseif ($student->custom_field_2 != null) {
            $enrolButton->class="btn btn-success disabled";
            $enrolButton->words=$student->custom_field_2;

            return $enrolButton;
        }
            else {
            $enrolButton->class="btn btn-info enabled";
            $enrolButton->words="Send ".$student->custom_field_8." enrolment.";

            return $enrolButton;
        }

    }

    public function setPaidButton($student){

        $depButton = new Button();

        if($student->custom_field_9 = "Yes"){
            $depButton->class="btn btn-success disabled";
            $depButton->words="<span class=\"glyphicon glyphicon-ok\"></span>";

            return $depButton;
        } else {
            $depButton->class="btn";
            $depButton->words="<span class=\"glyphicon glyphicon-remove\"></span>";

            return $depButton;
        }
    }



    public function setADButton($student){

        $adButton = new Button();

        if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null){
            if($student->user_email = "{{$student->name}}.{{$student->surname}}.@brentwood.ca"){
                $adButton->class="btn btn-success disabled";
                $adButton->words="AD Account Exists <span class=\"glyphicon glyphicon-ok\"></span>";

                return $adButton;
            } else {
                $adButton->class="btn bnt-info enabled";
                $adButton->words="Create AD Account";

                return $adButton;
            }
        } else {
            $adButton->class="btn disabled";
            $adButton->words="AD Account";

            return $adButton;
        }

    }

    public function setConsentButton(){
        // 5) informed consent has been sent/signed
        // If AD account complete button active

        // If no correspondence, "send informed consent form"

        // if correspondence greater than 0 "resend consent form"

        // if complete btn-success "Informed consent signed" with check mark

        // else button disabled

    }

    public function setCourseButton(){
        // 6) course selection sent/complete
        // If AD account complete button active

        // If no correspondence, "send course selection"

        // If correspondence greater than 0 "resend course selection"

        // if complete btn-success "course selection complete" with check mark

        // else button disabled

    }

    public function setHealthButton($student){
        // uses Bluehealth API
        $email = $student->email;
        $questionnaire_id = 3;
        $bhButton= new Button();

        try {
            $client = new $client->request('POST', 'https://go.bluehealth.ca/api.questionnaires/status', [
                'query' => ['action'=> 'AddQuestionnaireRecipient','patient_email' => $email,'questionnaire_id' => $questionnaire_id],
                'api_key' => ['cJaXrT2Ik8iG7Hps6IrGMXKILGgnzNPD']
            ]);

            //echo $apiRequest->getStatusCode());
            //echo $apiRequest->getHeader('content-type));

            $content = json_decode($apiRequest->getBody()->getContents());
        } catch (RequestException $re) {
            //for handling exception
        }

        if(true){
            //apiRequest->"complete"=true
                $bhButton->class="btn btn-success disabled";
                $bhButton->words="Health form complete <span class=\"glyphicon glyphicon-ok\"></span>";

                return $bhButton;
            } else {
                $bhButton->class="btn bnt-info enabled";
                $bhButton->words="Not Complete: send email";

                return $bhButton;
            }


    }



    public function setOrientationButton(){
        // 8) Orientation email sent
        // If ???? complete button active

        // If no correspondence, "send orientation email"

        // if correspondence greater than 0 "Orientation email sent" btn-success-
        // need drop down to resend

        // else button disabled


    }

    public function setPrefectButton(){
        // 9) Head Prefect email sent
        // If ???? complete button active

            // If no correspondence, "send head prefect email"

            // if correspondence greater than 0 "head prefect email sent" btn-success-
            // need drop down to resend

        // else button disabled


    }

    //following 'click' button functions deal with the action if a button is clicked
    //button state will disable a click if it should not be clicked
    public function sendValidation(){

    }

    public function resendValidation(){

    }

    public function changeStudentType(){

    }

    public function sendEnrolment(){

    }

    public function resendEnrolment(){

    }

    public function ADCreation(){

    }

    public function sendInformedConsent(){

    }

    public function resendIC(){

    }

    public function sendCourseSelection(){

    }

    public function resendCS(){

    }

    public function sendHealth(){
        //API call will know/deal with send or resend once Mike completes dev of this feature


    }

    public function sendOrientation(){

    }

    public function resendOrientation(){

    }

    public function sendPrefect(){

    }

    public function resendPrefect(){

    }

    public function increaseMessageCount($bid, $uid){
        //function to increment the amount of times a reminder has been sent for each button
        //need to pass button id here to ensure increasing the correct form's count
        // as well as the contact UID as these combine to ID on student_button table
        //this will be called every time the button is used to send a reminder

        $buttonID = $bid;
        $userID = $uid;

        //student_button is the table with a column called messages
//        $button = Button::find($buttonID);
//        $msgCount = $button->messages;
//        if($msgCount = null){
//            $newMsgCount = 0;
//        } else {
//            $newMsgCount = $msgCount +1;
//        }
//        $button->messages = $newMsgCount;
//        $button->update();
    }

    // following function for returning a button name based on id passed
    public function getName($id) {
        $button = Button::find($id);
        $name = $button->button_name;

        return $name;
    }

    public function apiCall($uid, $qid){
        $user_id = $uid;
        $questionnaire_id = $qid;

        try {
            $client = new $client->request('POST', 'https://brentwood.msm.io/custom/brentwood/data/api.php', [
                'query' => ['action'=> 'AddQuestionnaireRecipient','user_id' => $user_id,'questionnaire_id' => $questionnaire_id],
                'apikey' => [81633913542557427]
            ]);

            //echo $apiRequest->getStatusCode();
            //echo $apiRequest->getHeader('content-type));

            $content = json_decode($apiRequest->getBody()->getContents());
        } catch (RequestException $re) {
            //for handling exception
        }
    }

}
