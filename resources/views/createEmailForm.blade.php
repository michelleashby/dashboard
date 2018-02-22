@extends('layouts.app')

@section('content')
    <h1>You are adding a new correspondence/email</h1>
    <h4>Once created you will be able to associate this with a specific button</h4>
    {{--this form is used to create an email which is then associated to a button--}}

    <form method="POST" action="/createEmail" id ="createEmail">
        {{--following needed for authentication--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h3>Email Name: </h3>
        <textarea name="name" form="createEmail" rows="1" cols="40">Create a name for the email</textarea><br>

        <h3>Email type:</h3>
        <input type="radio" form="createEmail" name="type" value="notify" checked>Notify: Initial Email<br>
        <input type="radio" form="createEmail" name="type" value="reminder">Reminder: Reminder Email<br>


        <h3>Email Content:</h3>
        <textarea name="body" form="createEmail" rows="10" cols="70">Type your email here...</textarea>

        <input type="submit">

    </form>

@endsection


@section('footer')

    <br><a href='/home'>Back to Home</a>

@endsection