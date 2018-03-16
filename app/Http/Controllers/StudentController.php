<?php

namespace App\Http\Controllers;

use App\Button;
use App\Email;
use App\Step;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Code to get all new students NOTE needs tweaking
    public function getStudents(){
        if (Auth::check()) {

            $student = new Student();

            $students = $student->paginate(20);
//            dd($students);

            return $students;
        }
    }

    public function searchStudents()
    {

        $searchInput = $_POST['searchInput'];

//        dd($searchInput);

        if ($searchInput != null) {

            $student = new Student();

            //currently set up to searchname only  - can search on other columns in future if valuable
            $students = $student->where('contacts.name', 'LIKE', $searchInput)
                ->orWhere('contacts.surname', 'LIKE', $searchInput)
                ->distinct()
                ->get();

            $studentCount = $student->all()->count();

            if (count($students) == 0) {
                return '<h3>Sorry, no results for <u>' . $searchInput . '</u></h3>' .
                    "<br><a href='/home'>Back to Home</a>";
            } else {
                return view('home')->with('searchInput', $searchInput)->with('students', $students)->with('studentCount', $studentCount);
            }
        } else {
            return redirect('home');
        }
    }

    public function onClick($bid){
        $buttonID = $bid;
//        for testing:
//        Return "route works " . $buttonID;

        $button = Button::find($buttonID);
        $student = $button->student();

        $step = Step::find($button->step_id);

        $email = $step->email;

        //if enrolment email should = 0
        //have to figure out which email to send based on type
        if($step->email = null) {
            return "no email associated with this button - please contact admin. " .
                "<br><a href='/home'>Back to Home</a>";
        } elseif($step->email != null && $button->button_status_id == 0) {
            if ($student->student_type = "Canadian BC") {
                return "route works - got to " . $student->student_type .
                    "<br><a href='/home'>Back to Home</a>";


            } elseif ($student->student_type = "Canadian Boarding") {
                return "route works - got to " . $student->student_type .
                    "<br><a href='/home'>Back to Home</a>";

            } elseif ($student->student_type = "US Boarding") {
                return "route works - got to " . $student->student_type .
                    "<br><a href='/home'>Back to Home</a>";

            } elseif ($student->student_type = "International Boarding") {
                return "route works - got to " . $student->student_type .
                    "<br><a href='/home'>Back to Home</a>";

            } else {
                return "Student Type of " . $student->student_type . " not recognised" .
                    "<br><a href='/home'>Back to Home</a>";
            }
        }elseif($email->email_name = "bluehealth") {
            //API call for bluehealth

        } else {
            //API call function
            return "route works but logic is not";

        }



    }


}
