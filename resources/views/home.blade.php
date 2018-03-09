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

    <table class="table">
        <thead>
        <tr>
            <th>Student Name & ID</th>
            <th>Data Validation</th>
            <th>Student Type</th>
            <th>Enrolment</th>
            <th>Deposit Paid</th>
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

                {{--{{$studentButtons = $student->button()->orderby('step_id', 'ASC')->get()}}--}}


            {{--@if($studentButtons != null)--}}
                    @foreach($buttons as $button)
                    {{--logic in buttons still needs ot be implemented at this point--}}
                    {{--All buttons in DB should be called like below when dev of buttons is completed--}}

                {{--data validation--}}
                    {{--@if($student->custom_field_1 = "Yes")--}}

                        @if($button->step_id = 1 && $button->student_id = $student->student_id)
                        <td>
                        <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                            {{$button->button_words}}
                            @if($button->button_words = "Validation Complete")
                                <span class="glyphicon glyphicon-ok"></span>
                            @endif
                        </button>
                        </td>
                        @endif


                    {{--student-type--}}
                {{--will want this to flag if it changes for some reason... may be advanced function (wish list)--}}
                <td>{{$student->student_type}}</td>

                {{--Enrollment check--}}
                <td>
                    {{--Need enrolment to check if any emails sent as well as if it's still null--}}
                    @if($student->enrollment_status == null)
                        {{--This years' re-enrollment questionnaires are 157-161 - need to grab student type to determine which they get--}}
                        <button type="button" class="btn btn-info enabled" style="white-space: normal">send enrolment reminder</button> </td>
                    {{--Will also need if thay are new to school ---}}
                    {{--This years' enrollment questionnaires are not made yet - need to grab student type again to determine which they get--}}

                @else
                    <button type="button" class="btn btn-success disabled" style="white-space: normal">{{$student->enrollment_status}}
                        <span class="glyphicon glyphicon-ok"></span>
                    </button> </td>
                    @endif

                {{--deposit received--}}
                <td>
                    @if($student->deposit_received = "Yes")
                        <button type="button" class="btn btn-success disabled" aria-label="done">
                        <span class="glyphicon glyphicon-ok "></span></button>
                    @else
                                <button type="button" class="btn" aria-label="done">
                        <span class="glyphicon glyphicon-remove"></span></button>
                    @endif

                </td>

                {{--AD account check--}}
                <td>
                    {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}

                        @if($student->student_email = "{{$student->name}}.{{$student->surname}}.@brentwood.ca")
                            {{--this logic does not check AD - need to figure out how to do this--}}
                            <button type="button" class="btn btn-success disabled" style="white-space: normal">AD Account Exists
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        @else
                            <button type="button" class="btn bnt-info enabled" style="white-space: normal">Create AD Account</button>
                        @endif
                    {{--@else--}}
                        {{--<button type="button" class="btn disabled" style="white-space: normal">AD Account</button>--}}
                    {{--@endif--}}
                </td>

                {{--Informed Consent--}}
                    ($button->step_id = 4 && $button->student_id = $student->student_id)
                    <td>
                        <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                            {{$button->button_words}}
                            @if($button->button_words = "Informed Consent Given")
                                <span class="glyphicon glyphicon-ok"></span>
                            @endif
                        </button>
                    </td>
                    @endif


                {{--<td><button type="button" class="btn disabled" style="white-space: normal">Informed Consent</button> </td>--}}

                {{--<td><button type="button" class="btn disabled" style="white-space: normal">Send Course Selection</button> </td>--}}

                {{--<td>--}}
                    {{--below is NOT correct check need to know what would work--}}
                    {{--@if($student->insurance_no != null)--}}
                        {{--this logic does not check AD - need to figure out how to do this--}}
                        {{--<button type="button" class="btn btn-success disabled" style="white-space: normal">Health Form Complete--}}
                            {{--p<span class="glyphicon glyphicon-ok"></span>--}}
                        {{--</button>--}}
                    {{--@elseif($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                        {{--add a check that messages >= 0--}}
                        {{--@if($button->messages = 0)--}}
                            {{--<button type="button" class="btn btn-info enabled" style="white-space: normal">Send Health Form</button>--}}
                            {{--@else--}}
                            {{--<button type="button" class="btn btn-info enabled" style="white-space: normal">Send Health Form Reminder</button>--}}
                    {{--@endif--}}
                    {{--@else--}}
                        {{--<button type="button" class="btn disabled" style="white-space: normal">Send Health Form</button>--}}

                    {{--@endif--}}
                {{--</td>--}}

                {{--<td>--}}
                    {{--need to figure out the column in DB to check for this data still (if complete)--}}
                    {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                        {{--<button type="button" class="btn btn-info enabled" style="white-space: normal">Send Orientation Email</button> </td>--}}
                    {{--@else--}}
                        {{--<button type="button" class="btn disabled" style="white-space: normal">Resend Orientation Email</button> </td>--}}
                    {{--@endif--}}

                {{--<td>--}}
                    {{--need to figure out the column in DB to check for this data still (if complete)--}}
                    {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                        {{--<button type="button" class="btn b btn-info enabled" style="white-space: normal">Send Head Prefect Email</button> </td>--}}
                    {{--@else--}}
                        {{--<button type="button" class="btn disabled" style="white-space: normal">Resend Head Prefect Email</button> </td>--}}
                    {{--@endif--}}


                        @endforeach

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center">

    {{ $students->links() }}

    </div>

@endsection
