@extends('layouts.app')

@section('content')
    <div class="container center-block" style="width: 85%">
        <h1>Administration Panel</h1>

        <div class="container">
            <table class="table">
                <thead>
                <h3>Step Settings</h3>

                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Questionnaire ID</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($steps as $step)
                    <tr>
                        <td>{{$step->step_id}}</td>
                        <td>{{$step->step_name}}</td>
                        <td>
                            @if($step->email_id != null)
                                {{$step->email->email_name}}
                            @else
                            No email associated
                        @endif
                        </td>
                        <td>{{$step->questionnaire_id}}</td>
                        <td>
                            <button type="button" class="btn btn-info enabled" onclick="location.href='/editStep/{{$step->step_id}}'" style="white-space: normal">EDIT</button></td>
                       </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="container">
            <h3>Communications/Emails</h3>
            {{--Need to figure out how we want to store these, pull them, and edit them--}}
            {{--Is there a google drive plug in?--}}


            {{--edit button to be at bottom of table to change the questionnaire_id for future years--}}
            <button type="button" class="btn btn-info enabled" onclick="location.href='/createEmail'" style="white-space: normal">CREATE NEW EMAIL</button>

            <table class="table">
                <thead>
                <h3>Exsisting Communication Emails</h3>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody
                @foreach($emails as $email)
                    <tr>
                        <td>{{$email->email_id}}</td>
                        <td>{{$email->email_name}}</td>
                        <td><button type="button" class="btn btn-info enabled" onclick="location.href='/editEmail/{{$email->email_id}}'" style="white-space: normal">EDIT</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>
@endsection
