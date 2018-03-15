@extends('layouts.app')

@section('content')
    <div class="pull-right">
        <form method="POST" action="/home/search">
            {!! csrf_field() !!}

            <input type="text" name="searchInput" value="{{ old('searchInput') }}">

            <button type="submit">Search</button><br>
        </form>
    </div>
    <h1 class="display-3">{{$studentCount}} TEST students being admitted to Brentwood</h1>
    <form method="POST" action="/home/{{$button->button_id}}" id ="onClick">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <table class="table">
        <thead>
        <tr>
            <th>Student Name & ID</th>
            <th>Student Type</th>
            <th>Deposit Paid</th>
            <th>Data Validation</th>
            <th>Enrolment</th>
            <th>Create AD Account & Email</th>
            <th>Informed Consent</th>
            <th>Course Selection</th>
            <th>Health</th>
            <th>Orientation</th>
            <th>Email from Head Prefect</th>
        </tr>
        </thead>
        <tbody>
        {{--{{dd($students)}}--}}
        @foreach($students as $student)

            <tr> {{--student name and ID: no button used--}}

                <td>{{$student->name}} {{$student->surname}} <br> {{$student->student_id}}</td>

                {{--student-type--}}
                <td>{{$student->student_type}}</td>

                {{--deposit received--}}
                <td>
                    @if($student->deposit_received = "Yes")
                        <button type="submit" class="btn btn-success disabled" aria-label="done">
                            <span class="glyphicon glyphicon-ok "></span></button>
                    @else
                        <button type="button" class="btn" aria-label="done">
                            <span class="glyphicon glyphicon-remove"></span></button>
                    @endif

                </td>

                {{--@if($student->button->sudent_id = $student->student_id)--}}

                @foreach($student->button as $button)
                {{--{{$button->student_id}} {{$button->step_id}}--}}

                    <td>
                        {{ Form::button($button->button_words, array('class' => $button->button_class, 'style' => 'white-space: normal'))}}

                        {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                    {{--{{$button->button_words}}, {{$button->student_id}}--}}

                    {{--</button>--}}
                    </td>

                @endforeach
                {{--@endif--}}

            </tr>
        @endforeach
        </tbody>
    </table>
    </form>

    <div class="text-center">

        {{ $students->links() }}

    </div>

@endsection
