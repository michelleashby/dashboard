<?php

namespace App\Http\Controllers;

use App\Button;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Tests\B;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class ButtonController extends Controller
{
    // Going to use this to determine the state of each button
    // and pass this information to the Pages controller to be displayed on home
    // Rules will include:
    // a DB query to check state
    // rules as to the order of completion and when things can be complete
    // href links or hooks to complete action needed for centralization

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

    public function setButtons(){
        // create an array holding the buttons and their state as booleans?
        // based on if the following is true or false
        // buttons will be greyed out until they can be completed (btn disabled/active)
        // and then green(btn-success) when completed (btn ie.basic when active but not complete)
        // Brent talking about getting API calls to interact with answering these instead of queries


        // 1) messages sent - total count
        // not sure if this is DB stored and if not the reminder counts for each button may be enough


        // 2) data validation sent/completed
        // if data validation has not been sent (0 correspondence) "send validation" with btn

        // if correspondence is greater than 0 but validation not complete, "resend validation" with btn

        // if validation complete button btn-success and "validation complete" with check mark

        // 3a)student type
        // NEW REQUEST from PK
        // Student type - flag if changes so it can be acknowledged
        // Considering pulling this info and setting in column here:


        // 3b) Enrolment sent/complete
        // If deposit paid then button = btn active

            // if no correspondence "send enrolment'

            // if correspondence greater than 0 but enrolment not complete, "resend enrolment"

            // if complete button = btn-success "enrolment complete" with check mark

        // else button disabled


        // 3c) deposit paid - check mark or ex only dealt with in view currently


        // 4) AD account created
        // If enrolment complete then button = btn active

            // If AD account exists "account has been created" btn-success

            // else "create AD account"

        // else button disabled

        // 5) informed consent has been sent/signed
        // If AD account complete button active

            // If no correspondence, "send informed consent form"

            // if correspondence greater than 0 "resend consent form"

            // if complete btn-success "Informed consent signed" with check mark

        // else button disabled

        // 6) course selection sent/complete
        // If AD account complete button active

            // If no correspondence, "send course selection"

            // If correspondence greater than 0 "resend course selection"

            // if complete btn-success "course selection complete" with check mark

        // else button disabled

        // 7) Blue health form sent/complete
        // If AD account complete button active

            // If no correspondence, "send health form"

            // if correspondence greater than 0 "resend health form"

            // if complete btn-success "blue health form complete" with check mark

        // else button disabled

        // 8) Orientation email sent
        // If ???? complete button active

            // If no correspondence, "send orientation email"

            // if correspondence greater than 0 "Orientation email sent" btn-success-
            // need drop down to resend

        // else button disabled


        // 9) Head Prefect email sent
        // If ???? complete button active

            // If no correspondence, "send head prefect email"

            // if correspondence greater than 0 "head prefect email sent" btn-success-
            // need drop down to resend

        // else button disabled


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

    public function getName($id) {
        $button = Button::find($id);
        $name = $button->button_name;

        return $name;
    }

    public function apiCall(){
        try {
            $client = new $client->request('GET', 'http://website.com/API/whateverURL', [
                'query' => ['user_id' => 'PASSED FROM UI','questionnaire_id' => 'ALSO PASSED'],
                'auth' => ['Name', 'PSWD'], //if needed
                'debug' => true //if needed
            ]);

            //echo $apiRequest->getStatusCode());
            //echo $apiRequest->getHeader('content-type));

            $content = json_decode($apiRequest->getBody()->getContents());
        } catch (RequestException $re) {
            //for handling exception
        }
    }

}
