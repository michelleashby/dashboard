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



}
