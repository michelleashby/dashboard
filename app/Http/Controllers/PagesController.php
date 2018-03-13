<?php

namespace App\Http\Controllers;

use App\Email;
use App\Step;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Button;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\StudentController;

class PagesController extends Controller
{

    // For the time being, if authenticated (signed in)
    // show the data
    public function displayHome() {
        if (Auth::check()) {

            $student = new Student();

            $students = $student->paginate(20);

            $studentCount = $student->all()->count();

            $dbSync = DB::connection('mysql')->select('select * from db_sync order by updated_at DESC limit 1', 'ARRAY_A');
//            dd($dbSync);

            return view('home')->with('students', $students)->with('studentCount', $studentCount)->with('dbDate', $dbSync);
        } else {
            return view('welcome');
        }
    }

    public function displayAdmin(){
        if(Auth::check()){
            $step = new Step();
            $steps = $step->all();

            $email = new Email();
            $emails = $email->all();

            return view('admin')->with('steps', $steps)->with('emails', $emails);
        } else {
            return view('welcome');
        }
    }

    public function displayStep($id){

        $step = Step::find($id);

        $email = new Email();
        $emails = $email->all()->where('active', '=', 1);

        return view('editStepForm')->with('step', $step)->with('emails', $emails);
    }

    public function displayCreateEmail(){
        return view('createEmailForm');
    }

    public function displayEditEmail($id){

        $email = Email::find($id);

        return view('editEmailForm')->with('email', $email);
    }



}
