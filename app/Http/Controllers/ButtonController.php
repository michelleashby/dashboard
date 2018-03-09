<?php

namespace App\Http\Controllers;

use App\Button;
use App\Status;
use App\Step;
use App\Student;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Tests\B;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ButtonController extends Controller
{
    // Going to use this to determine the state of each button
    // and pass this information to the Pages controller to be displayed on home
    // Rules will include:
    // a DB query to check state
    // rules as to the order of completion and when things can be complete
    // href links or hooks to complete action needed for centralization

//Status meanings for questionnaire_submission.questionnaire_submission_status_id
//Needed for putting buttons in correct state
//0              =>           "Not invited",
//1              =>           "Invited but not completed",
//2              =>           "Completed",
//3              =>           "Main guardian email missing",



    public function getStudentButtons($id){
        // returns an array of all buttons
        $button = new Button();
        $buttons = $button->where('student_id', $id)->orderBy('button_id', 'ASC')->get();

        return $buttons;
    }

    public function getButtons(){
        $button = new Button();
        $buttons = $button->all();

        return $buttons;
    }

    public function createStudentButtons($student){
        $id = $student->student_id;
        $date = Carbon::now();

        $button = new Button();
        $buttonsCheck = $button->where('student_id',$id)->count();

        //need to double check that the button does not exist so duplicate buttons are not being created
        if($buttonsCheck < 1) {
            $step = new Step;
            $steps = $step->all();

            foreach($steps as $step) {
                $button = new Button();

                $button->student_id = $id;
                $button->step_id = $step->step_id;
                $button->created_at = $date;

                $button->save();
            }
        } else {
            return "cannot create buttons for user who already has ". $buttonsCheck ." button(s).";
        }


    }


    // buttons will be greyed out until they can be completed (btn disabled/active)
    // and then green(btn-success) when completed (btn ie.basic when active but not complete)
    // these functions query DB for current state of action for buttons' associated form
    // all set functions for buttons follow:
    public function setValidationButton($student){

        $id = $student->student_id;
        $step = Step::find(1);
        $date = Carbon::now();


        // need to find button with user_id of the student and step_id 1
        $button = new Button();
        $button = $button->where('student_id', $id)
            ->where('step_id', 1)
            ->get();
//        dd($button);

        if($button == null){
            $valButton = new Button();
            //if there is no validation button in the button table, create one
            $valButton->student_id = $id;
            $valButton->step_id = $step;
            $valButton->created_at = $date;
            $valButton->button_status_id = 0;

            $valButton->save();
        } else {
            //if button exists update to correspond with MySchool table status
            $questStatus = new Status();
            $questionnaireID = $step->questionnaire_id;
            $button_id = $button->button_id;

            $valStatus = $questStatus->select('questionnaire_status.questionnaire_id',
                'questionnaire_status.questionnaire_submission_status_id')
                ->where('questionnaire_status.user_id','=',$id)
                ->where('questionnaire_status.questionnaire_id','=',$questionnaireID)
                ->get();

            //if ($valStatus->questionnaire_submission_status_id = 2) //2 = complete
            if ($student->custom_field_1 = "Yes") {
                $valButton = Button::find($button_id);

                $valButton->class = "btn btn-success disabled";
                $valButton->words = "Validation Complete  <span class=\"glyphicon glyphicon-ok\"></span>";
                $valButton->status_id = 2;

                $valButton->update();
            } elseif ($valStatus->questionnaire_submission_status_id = 1) { //1 = sent but not complete
                $valButton = Button::find($button_id);

                // If student is in the validation questionnaire and has not completed
                $valButton->class = "btn btn-info";
                $valButton->words = "Resend Data Validation";
                $valButton->status_id = 1;

                $valButton->update();
            } elseif ($valStatus->questionnaire_submission_status_id = 0 || $valStatus->questionnaire_submission_status_id = null) { // 0 = not sent or null record not created
                $valButton = Button::find($button_id);

                $valButton->class = "btn btn-info";
                $valButton->words = "Send Data Validation";
                $valButton->status_id = 0;

                $valButton->update();
            } else {
                return "error updating validation button";
            }
        }

    }

//    public function setTypeButton(){
        // 3a)student type
        // NEW REQUEST from PK
        // Student type - flag if changes so it can be acknowledged
        // Considering pulling this info and setting in column here:
        // accessing $student->custom_field_8 gives this information
        //no need for function, can be called in view

//    }

    public function setEnrolmentButton($student){

        $id = $student->id;

        // need to find button with user_id of the student and step_id 1
        $button = new Button();
        $valButton = $button->where('user_id', $id)
            ->where('step_id', 2)
            ->get();
        $type = $student->custom_field_8;

        $step = 2;

        $questStatus = new Status();
        $questionnaireID = $step->questionnaire_id;

        $enrolStatus = $questStatus->select('questionnaire_status.questionnaire_id',
            'questionnaire_status.questionnaire_submission_status_id')
            ->where('questionnaire_status.user_id','=',$id)
            ->where('questionnaire_status.questionnaire_id','=',$questionnaireID)
            ->get();

        //if ($valStatus->questionnaire_submission_status_id = 2) //2 = complete
        if($student->custom_field_2 == null){ //if questionnaires has ID of current enrollment and status of 1 invited but not complete
            $enrolButton->class="btn btn-info enabled";
            $enrolButton->words="Resend enrolment reminder";

            $enrolButton->update();
        }
        elseif ($enrolStatus->questionnaire_submission_status_id = 1) { //1 = sent but not complete
            // If student is in the validation questionnaire and has not completed
            $enrolButton->class = "btn btn-info";
            $enrolButton->words=$student->custom_field_2;

            $enrolButton->update();
        }
        elseif ($enrolStatus->questionnaire_submission_status_id = 0 || $enrolStatus->questionnaire_submission_status_id = null) { // 0 = not sent or null record not created

            $enrolButton->class="btn btn-info enabled";
            $enrolButton->words="Send ".$student->custom_field_8." enrolment.";

            $enrolButton->update();
        }
        else {
            return error;
        }

    }

    public function setPaidButton($student){

        $depButton = new Button();

        if($student->custom_field_9 = "Yes"){
            $depButton->class="btn btn-success disabled";
            $depButton->words="<span class=\"glyphicon glyphicon-ok\"></span>";

            $depButton->update();
        } else {
            $depButton->class="btn";
            $depButton->words="<span class=\"glyphicon glyphicon-remove\"></span>";

            $depButton->update();
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

//        Development server dev.bluehealth.ca/api.questionnaires/status
//        real time go.bluehealth.ca/api.questionnairesstatus

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

    public function getValidationButton($student){
        $id = $student->user_id;

        $button = new Button();

        $valButton = $button->where('user_id', $id)
            ->where('step_id', 1)
            ->get();

        return $valButton;
    }

    //following 'click' button functions deal with the action if a button is clicked
    //button state will disable a click if it should not be clicked
    public function sendValidation(){

    }

    public function resendValidation(){

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

    // Below function will be built into later versions to record data about correspondence
    // first latest and how many messages sent
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

    public function dbSync(){
        if(Auth::check()) {
            $date = Carbon::now();


            // Need a function that can be called to sync DB tables from MySchool
            // As well as populate button table based on status

            // Get tables from external DB
            // Tables needing sync include:
            // contacts,students,classes,class_students,class_levels,questionnaires,questionnaire_submissions

            // Truncate local tables that require syncing
//            DB::statement('DROP TABLE contacts,students,classes,class_students,class_levels,questionnaires,questionnaire_submissions');


            //Trying to narrow down the submissions returned (by date) but would be better to just grab the ones for active questionnaires
            $submissions = DB::connection('myschoolsql')->select('select * from questionnaire_submissions where completion_datetime > "2017%"' );
//            dd($submissions);
            DB::connection('mysql')->table('questionnaire_status')->truncate();

            foreach($submissions as $submission){
                //insert into questionnaire status
                $id = $submission->questionnaire_submission_id;
                $qid = $submission->questionnaire_id;
                $uid = $submission->user_id;
                $status_id = $submission->questionnaire_submission_status_id;
                $completion = $submission->completion_datetime;

                DB::connection('mysql')->table('questionnaire_status')->insert(
                    ['questionnaire_submission_id' => $id, 'questionnaire_id' => $qid, 'user_id' => $uid,
                        'questionnaire_submission_status_id' => $status_id, 'completion_datetime' => $completion]
                );
            }

            // student sync
            $mySchoolStudents = DB::connection('myschoolsql')->select('SELECT DISTINCT contacts.user_id,
                contacts.surname,
                contacts.name,
                students.custom_field_8,
                students.custom_field_1,
                students.custom_field_9,
                students.custom_field_2
                FROM contacts
                JOIN class_students
                ON contacts.user_id = class_students.user_id
                JOIN classes
                ON class_students.class_id = classes.class_id
                JOIN class_levels
                ON classes.class_level_id = class_levels.class_level_id
                JOIN students
                ON contacts.user_id =students.user_id
                WHERE classes.year = 2018
                AND contacts.user_id > 1810');
            //LAST LINE HERE IS A HACK BECAUSE OLD DATA WAS GETTING THROUGH OTHER WHERE CLAUSE

            DB::connection('mysql')->table('student')->truncate();

            foreach($mySchoolStudents as $student){
                $id = $student->user_id;
                $surname = $student->surname;
                $name = $student->name;
                $type = $student->custom_field_8;
                $val = $student->custom_field_1;
                $dep = $student->custom_field_9;
                $enrol = $student->custom_field_2;

                DB::connection('mysql')->table('student')->insert(
                ['student_id' => $id,'surname' => $surname, 'name'=> $name,'student_type' => $type,
                    'data_valadation_complete' => $val, 'deposit_received' => $dep,'enrollment_status' => $enrol]
                );

            }

            //may want a mysqldump instead
            //mysqldump may need to be done in shell_exec('your command here')
            //mysqldump -u -p DBname contacts students classes class_students class_levels
            // questionnaires questionnaire_submissions > dbsync.$date.sql

            //use .sql file to re-build tables we dropped
            // Again maybe shell_exec('your command here') with ./dbsync.$date.sql?

            // Local table `button` syncing
            // Create buttons for new students or students missing them
            // Update buttons for current students is submission status changed
            $student = new Student();
            $students =  $student->paginate(20);
//            dd($students);

            foreach ($students as $student) {
                //grab the students to make sure they each have 8 buttons in table

                $button = new Button();
                $studentButtonCount = $button->where('student_id',$student->student_id)->count();
//                dd($studentButtonCount);

                if ($studentButtonCount > 0) {
                    //Update statuses for existing buttons
                    //Same set function creates the button if it does not exist
                    //Need to call set function for each button
                    $this->setValidationButton($student);

                } else {
                    //add all buttons
                    $this->createStudentButtons($student);
                }

                $studentButtons = $student->button()->orderby('step_id', 'ASC')->get();

            }

            $studentCount = $student->all()->count();

//            $button = new Button();
//            $buttons = $button->all();

            DB::connection('mysql')->table('db_sync')->where('id',1)->update([
                'updated_at' => $date
            ]);


            return view('home')->with('students', $students)->with('studentButtons', $studentButtons)->with('studentCount',$studentCount);
        }else {
            return view('welcome');
        }

    }

}
