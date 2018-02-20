@extends('layouts.app')

@section('content')
    <h1>You are editing a correspondence/email</h1>
    <h4>{{$email->email_name}}</h4>
    {{--this form is used to create an email which is then associated to a button--}}

    <form method="POST" action="/editEmail/{{$email->email_id}}" id ="editEmail">
        {{--following needed for authentication--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h3>Email Name: </h3>
        <textarea name="name" form="editEmail" rows="1" cols="40">{{$email->email_name}}</textarea><br>

        <h3>Email type currently set to {{$email->type}}</h3>
        <h4>Leave blank if not changing</h4>
        <h3>Change to:</h3>
        <input type="radio" form="editEmail" name="type" value="notify">Notify: Initial Email<br>
        <input type="radio" form="editEmail" name="type" value="reminder">Reminder: Reminder Email<br>


        <h3>Email Content:</h3>
        <textarea name="body" form="editEmail" rows="10" cols="70">{{$email->body}}</textarea>

        <h3>Active? Currently
            @if($email->active == 1)
                Yes
            @else
                No
            @endif
        </h3>
        <h4>Leave blank if not changing</h4>
        <input type="radio" form="editEmail" name="active" value="1">Yes<br>
        <input type="radio" form="editEmail" name="active" value="0">No<br>


        <input type="submit">

    </form>

@endsection