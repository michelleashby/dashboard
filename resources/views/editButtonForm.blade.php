@extends('layouts.app')

@section('content')
    <div class="container center-block" style="width: 85%">

    <h1>You are editing the button: {{$button->button_name}}</h1>
    {{--this form is used to edit which email is associated to which emails so that it can be updated annually--}}

    <form method="POST" action="/editButton/{{$button->button_id}}" id ="editButton">
        {{--following needed for authentication--}}
        <input type="hidden" name="token" value="{{ csrf_token() }}">

        <h3>Button Name: </h3>
        <textarea name="name" form="editButton" rows="1" cols="40">{{$button->button_name}}</textarea><br>

        <h3>Email sent with button:</h3>
        <input type="radio" form="editButton" name="email" value="{{$button->email_id}}" checked>
        {{--{{App\Email::find($button->email_id)->email_name}}<br>--}}
        The name of some email
        {{--@foreach($emails as $email)--}}
            {{--<input type="radio" form="editButton" name="email" value="{{$email->email_id}}">{{$email->email_name}}<br>--}}
        {{--@endforeach--}}

        <h3>Questionnaire associated with button:</h3>
        <textarea name="questionnaire_id" form="editButton" rows="1" cols="8">{{$button->questionnaire_id}}</textarea><br>


    </form>

    </div>

@endsection