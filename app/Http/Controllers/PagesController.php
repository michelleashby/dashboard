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
//
//            $students = $student->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
//            ->join('classes', 'class_students.class_id', '=', 'classes.class_id')
//            ->join('class_levels', 'classes.class_level_id', '=', 'class_levels.class_level_id')
//            ->join('students', 'contacts.user_id', '=', 'students.user_id')
//            ->select('contacts.user_id',
//                'contacts.surname',
//                'contacts.name',
//                'students.custom_field_8',  // custom_field_8 is "Student Type"
//                'students.custom_field_13', // custom_field_13 is "Discount Value CAD"
//                'students.custom_field_1',  // custom_field_1 is "Data Validation Complete"
//                'students.custom_field_9', // custom_field_9 is "Deposit Received"
//                'students.custom_field_2') // custom_field_2 is "Enrollment Status"
//            ->where('classes.year', '=', 2018)
//            ->orderby('contacts.surname')
//            //->where('students.custom_field_1', '=', 'Yes')
//            //->where('students.custom_field_2', '=', 'Attending 2017-2018')
//            //->where('students.custom_field_9', '=', 'Yes')
//            //->orderby('class_levels.class_level_index')
////            ->get();
//            ->paginate(20);
////            dd($students);

            $studentCount = $student->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
                ->join('classes', 'class_students.class_id', '=', 'classes.class_id')
                ->join('class_levels', 'classes.class_level_id', '=', 'class_levels.class_level_id')
                ->join('students', 'contacts.user_id', '=', 'students.user_id')
                ->select('contacts.user_id',
                    'contacts.surname',
                    'contacts.name',
                    'students.custom_field_8',  // custom_field_8 is "Student Type"
                    'students.custom_field_13', // custom_field_13 is "Discount Value CAD"
                    'students.custom_field_1',  // custom_field_1 is "Data Validation Complete"
                    'students.custom_field_9', // custom_field_9 is "Deposit Received"
                    'students.custom_field_2') // custom_field_2 is "Enrollment Status"
                ->where('classes.year', '=', 2018)
                ->count();

            $students = App\Student::getStudents();

            $button = new Button();
            $buttons = $button->all();

            return view('home')->with('students', $students)->with('buttons', $buttons)->with('studentCount', $studentCount);
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
