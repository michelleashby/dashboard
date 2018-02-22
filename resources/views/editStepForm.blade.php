@extends('layouts.app')

@section('content')

    <div class="container center-block" style="width: 85%">

    <h1>You are editing the step: {{$step->step_name}}</h1>
    {{--this form is used to edit which email is associated to which emails so that it can be updated annually--}}

    <form method="POST" action="/editStep/{{$step->step_id}}" id ="editStep">
        {{--following needed for authentication--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h3>Step Name: </h3>
        <textarea name="name" form="editStep" rows="1" cols="40">{{$step->step_name}}</textarea><br>

        <h3>Email sent with this step currently set to {{$step->email->email_name}}</h3>
        <h3>Change to:</h3>
        {{--active emails passed with view--}}
        {{--<input type="radio" form="editStep" name="email" value="{{$email->email_id}}" checked>--}}
        @foreach($emails as $email)
            <input type="radio" form="editStep" name="email" value="{{$email->email_id}}">{{$email->email_name}}<br>
        @endforeach

        <h3>Questionnaire associated with this step:</h3>
        <textarea name="questionnaire_id" form="editStep" rows="1" cols="8">{{$step->questionnaire_id}}</textarea><br>

        <input type="submit">

    </form>

    </div>

@endsection

@section('footer')

    <br><a href='/home'>Back to Home</a>

@endsection