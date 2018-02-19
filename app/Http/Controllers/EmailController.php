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
        //get all email and return names & id for use in UI

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
        $email->created_at = Carbon::now();
        $email->save();

        return redirect()->action('PagesController@displayAdmin');
    }

    public function editEmail($id){
        // needs to be passed id to grab correct email values
        $email = Email::find($id);

        return view('editEmailForm')->with('email', $email);
    }

    public function saveEmail($id){
        // saves an email after editing
        // also requires id to update correct email
        // get data posted from form
        $name = Input::get('name');
        $type = Input::get('type');
        $body = Input::get('body');

        $email = Email::find($id);
        //check if name has changed
        if($email->name != $name || $email->type != $type || $email->body != $body){
            $email->name = $name;
            $email->type = $type;
            $email->body = $body;
            $email->updated_at = Carbon::now();
            $email->update();

            return redirect()->action('PagesController@displayAdmin');
        } else {
            return "No changes detected for email" . '<br><a class="btn btn-primary btn-lg" href="/admin" role="button">Return to Admin</a>';
        }

    }

}