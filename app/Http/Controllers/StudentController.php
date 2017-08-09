<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Code to get all new students NOTE needs tweaking
    public function getStudents(){
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

        return $students;
    }

    public function searchStudents(){
        $searchInput = $_POST['searchInput'];

        //currently set up to searchname only  - can search on other columns in future if valuable
        $searchStudents = DB::table('contacts')
            ->where('name', 'LIKE', "%{searchInput}%")
            ->orWhere('surname', 'LIKE', "%{searchInput}%")
            ->get();

        if(count($searchStudents) == 0){
            return '<h3>Sorry, no results for <u>' . $searchInput . '</u></h3>';
        }
        else {
            return view('searchResult')->with('searchInput', $searchInput)->with('searchStudents', $searchStudents);
        }
    }

}