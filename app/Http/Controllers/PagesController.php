<?php

namespace App\Http\Controllers;

use App\Email;
use App\Step;
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

//            (new Student)->getStudents();
            $student = new Student();

            //NOTE: for reference
            // custom_field_8 is "Student Type",
            // custom_field_13 is "Discount Value CAD",
            // custom_field_1 is "Data Validation Complete",
            // custom_field_9 is "Deposit Received",
            // custom_field_2 is "Enrollment Status"
            $students = $student->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
            ->join('classes', 'class_students.class_id', '=', 'classes.class_id')
            ->join('class_levels', 'classes.class_level_id', '=', 'class_levels.class_level_id')
            ->join('students', 'contacts.user_id', '=', 'students.user_id')
            ->select('contacts.user_id',
            'contacts.surname',
            'contacts.name',
            'students.custom_field_8',
            'students.custom_field_13',
            'students.custom_field_1',
            'students.custom_field_9',
            'students.custom_field_2')
            ->where('classes.year', '=', 2018)
            //->where('students.custom_field_1', '=', 'Yes')
            //->where('students.custom_field_2', '=', 'Attending 2017-2018')
            //->where('students.custom_field_9', '=', 'Yes')
            //->orderby('class_levels.class_level_index')
            ->get();
//            dd($students);

//            $students = Student::getStudents();

            $button = new Button();
            $buttons = $button->all();

            return view('home')->with('students', $students)->with('buttons', $buttons);
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

    public function dbSync(){
        if(Auth::check()) {

            // Need a function that can be called to sync DB tables from MySchool
            // As well as populate button table based on status

            // Get tables from external DB
            // Tables needing sync include:
            // contacts,students,classes,class_students,class_levels,questionnaires,questionnaire_submissions

//        $dbUser = 'brentwood_ro'
//        $dbPassword = '%+m!$YQM4]X*rov'
//        $dbDatabase = 'brentwood'
//        $dbServer = 'door.msm.io'


            // Local table `button` also needs to populate something like:
            // UPDATE button.button_status_id = questionnaire_submission.questionnaire_submission_status_id
            // WHERE button.user_id = questionnaire_submission.user_id
            // AND button->step.questionnaire_id = questionnaire_submission.questionnaire_id
            $students = Student()->all;

            foreach ($students as $student) {
                //grab the students IDs to make sure they each have 8 buttons in table
                $studentButton = new Button();

                $studentButtonCount = $studentButton->where('user_id', $student->user_id)->count();

                if ($studentButtonCount == 8 || $studentButtonCount > 0) {
                    //Update statuses for existing buttons
                    //Same set function creates the button if it does not exist
                    //Need to call set function for each button
                    $studentButton::setValidationButton($student);

                } else {
                    //add all buttons
                    $studentButton::createStudentButtons($student);
                }
            }
            $student = new Student();

            //NOTE: for reference
            // custom_field_8 is "Student Type",
            // custom_field_13 is "Discount Value CAD",
            // custom_field_1 is "Data Validation Complete",
            // custom_field_9 is "Deposit Received",
            // custom_field_2 is "Enrollment Status"
            $students = $student->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
                ->join('classes', 'class_students.class_id', '=', 'classes.class_id')
                ->join('class_levels', 'classes.class_level_id', '=', 'class_levels.class_level_id')
                ->join('students', 'contacts.user_id', '=', 'students.user_id')
                ->select('contacts.user_id',
                    'contacts.surname',
                    'contacts.name',
                    'students.custom_field_8',
                    'students.custom_field_13',
                    'students.custom_field_1',
                    'students.custom_field_9',
                    'students.custom_field_2')
                ->where('classes.year', '=', 2018)
                //->where('students.custom_field_1', '=', 'Yes')
                //->where('students.custom_field_2', '=', 'Attending 2017-2018')
                //->where('students.custom_field_9', '=', 'Yes')
                //->orderby('class_levels.class_level_index')
                ->get();
//            dd($students);

//            $students = Student::getStudents();

            $button = new Button();
            $buttons = $button->all();

            return view('home')->with('students', $students)->with('buttons', $buttons);
        }else {
            return view('welcome');
        }

    }


}
