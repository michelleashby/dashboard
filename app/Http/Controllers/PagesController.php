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

//            $students = Student::getStudents();
            foreach ($students as $student) {
                $button = new Button();
                $id = $student->student_id;
                $buttons = $button->where('student_id',$id)->orderby('step_id', 'ASC')->get();
            }


            $dbDate = DB::connection('mysql')->select('select * from db_sync where id=1');
            dd($dbDate);

            return view('home')->with('students', $students)->with('studentCount', $studentCount)->with('buttons', $buttons)->with('dbDate', $dbDate);
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

    // below is for search box function to be developed eventually
//    public function search() {
//        // Should be able to search by form student name or form status
//        $serachInput = $_POST['searchInput'];
//
//        $searchStudents = DB::table('students')
//            ->where('first_name', 'LIKE', "{$searchInput}");
//
//    }


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
