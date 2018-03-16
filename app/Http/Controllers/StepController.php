<?php

namespace App\Http\Controllers;

use App\Step;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Input;



class StepController extends Controller
{
    // Going to use this to determine the state of each button
    // and pass this information to the Pages controller to be displayed on home
    // Rules will include:
    // a DB query to check state
    // rules as to the order of completion and when things can be complete
    // href links or hooks to complete action needed for centralization

    public function editStep($id)
    {

        $stepName = Input::get('name');
        $stepEmail = Input::get('email');
        $questionnaireId = Input::get('questionnaire_id');
        $description = Input::get('description');

        $step = Step::find($id);

        if ($stepEmail == null) {
            $stepEmail = $step->step_email;
        }
//        Check if data has changed
        if ($step->description != $description || $step->step_name != $stepName ||
            $step->questionnaire_id != $questionnaireId || $step->step_email != $stepEmail) {
            //if input fields are not the same as the stored values for button
            //update them to be the same
            //will need to incorporate email attached here when developed
            $step->step_name = $stepName;
            $step->questionnaire_id = $questionnaireId;
            $step->email_id = $stepEmail;
            $step->description = $description;

            $step->update();

        } else {
//            if nothing changed
            return "No changes detected for this step's configuration" . '<br><a class="btn btn-primary btn-lg" href="/admin" role="button">Return to Admin</a>';


        }

        return redirect()->action('PagesController@displayAdmin');
    }




}