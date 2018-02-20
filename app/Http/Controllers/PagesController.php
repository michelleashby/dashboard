<?php

namespace App\Http\Controllers;

use App\Email;
use App\Student;
use Illuminate\Http\Request;
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
            $students = $student->getStudents();


//            //NOTE: for reference
//            // custom_field_8 is "Student Type",
//            // custom_field_13 is "Discount Value CAD",
//            // custom_field_1 is "Data Validation Complete",
//            // custom_field_9 is "Deposit Received",
//            // custom_field_2 is "Enrollment Status"
//            $students = $student->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
//            ->join('classes', 'class_students.class_id', '=', 'classes.class_id')
//            ->join('class_levels', 'classes.class_level_id', '=', 'class_levels.class_level_id')
//            ->join('students', 'contacts.user_id', '=', 'students.user_id')
//            ->select('contacts.user_id',
//            'contacts.surname',
//            'contacts.name',
//            'students.custom_field_8',
//            'students.custom_field_13',
//            'students.custom_field_1',
//            'students.custom_field_9',
//            'students.custom_field_2')
//            ->where('classes.year', '=', 2018)
//            //->where('students.custom_field_1', '=', 'Yes')
//            //->where('students.custom_field_2', '=', 'Attending 2017-2018')
//            //->where('students.custom_field_9', '=', 'Yes')
//            //->orderby('class_levels.class_level_index')
//            ->get();
////            dd($students);

//            $students = Student::getStudents();
            return view('home')->with('students', $students); //->with('buttons', $buttons);
        } else {
            return view('welcome');
        }
    }

    public function displayAdmin(){
        if(Auth::check()){
            $button = new Button();
            $buttons = $button->all();

            $email = new Email();
            $emails = $email->all();

            return view('admin')->with('buttons', $buttons)->with('emails', $emails);
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


    public function displayEditButton($id){

        $button = Button::find($id);

        $email = new Email();
        $emails = $email->all()->where('active', '=', 1);

        return view('editButtonForm')->with('button', $button)->with('emails', $emails);
    }

    public function displayCreateEmail(){
        return view('createEmailForm');
    }

    public function displayEditEmail($id){

        $email = Email::find($id);

        return view('editEmailForm')->with('email', $email);
    }


}
