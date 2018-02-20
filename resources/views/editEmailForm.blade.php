@extends('layouts.app')

@section('content')
    <h1>You are adding a new correspondence/email</h1>
    <h4>Once created you will be able to associate this with a specific button</h4>
    {{--this form is used to create an email which is then associated to a button--}}

    <form method="POST" action="/editEmail/{{$email->email_id}}" id ="editEmail">
        {{--following needed for authentication--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h3>Email Name: </h3>
        <textarea name="name" form="editEmail" rows="1" cols="40">{{$email->name}}</textarea><br>

        <h3>Email type currently set to {{$email->type}}</h3>
        <h3>Change to:</h3>
        <input type="radio" form="editEmail" name="type" value="notify">Initial Email<br>
        <input type="radio" form="editEmaill" name="type" value="reminder">Reminder Email<br>


        <h3>Email Content:</h3>
        <textarea name="body" form="createEmail" rows="10" cols="70">{{$email->body}}</textarea>

        <input type="submit">

    </form>

@endsection