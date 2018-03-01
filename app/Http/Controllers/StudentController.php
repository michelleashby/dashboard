<?php

namespace App\Http\Controllers;

use App\Button;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Code to get all new students NOTE needs tweaking
    public function getStudents(){
        if (Auth::check()) {

            $student = new Student();

            $students = $student->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
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
                    'students.custom_field_2')// custom_field_2 is "Enrollment Status"
                ->where('classes.year', '=', 2018)
                ->orderby('contacts.surname')
                //->where('students.custom_field_1', '=', 'Yes')
                //->where('students.custom_field_2', '=', 'Attending 2017-2018')
                //->where('students.custom_field_9', '=', 'Yes')
                //->orderby('class_levels.class_level_index')
//            ->get();
                ->paginate(20);
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
            $students = $student
                ->join('class_students', 'contacts.user_id', '=', 'class_students.user_id')
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
                ->where('contacts.name', 'LIKE', $searchInput)
                ->orWhere('contacts.surname', 'LIKE', $searchInput)
                ->distinct()
                ->get();

            $button = new Button();
            $buttons = $button->all();

            if (count($students) == 0) {
                return '<h3>Sorry, no results for <u>' . $searchInput . '</u></h3>';
            } else {
                return view('home')->with('searchInput', $searchInput)->with('students', $students)->with('buttons',$buttons);
            }
        } else {
            return redirect('home');
        }
    }


}
