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

                {{--@foreach($student->button as $button)--}}
                @foreach($buttons->sortby('student_id')->sortby('step_id') as $button)

                    @if($button->sudent_id = $student->student_id)
                    {{--data validation--}}
                    {{--@if($student->custom_field_1 = "Yes")--}}

                        <td>
                            <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                                {{$button->button_words}}
                                @if($button->button_words = "Validation Complete")
                                    <span class="glyphicon glyphicon-ok"></span>
                                @endif
                            </button>
                        </td>

                    {{--student-type--}}
                    {{--will want this to flag if it changes for some reason... may be advanced function (wish list)--}}
                    <td>{{$student->student_type}}</td>

                    {{--Enrollment check--}}
                    <td>
                        {{--Need enrolment to check if any emails sent as well as if it's still null--}}
                        @if($student->enrollment_status == null)
                            {{--This years' re-enrollment questionnaires are 157-161 - need to grab student type to determine which they get--}}
                            <button type="button" class="btn btn-info enabled" style="white-space: normal">send enrolment reminder</button>
                            {{--Will also need if thay are new to school ---}}
                            {{--This years' enrollment questionnaires are not made yet - need to grab student type again to determine which they get--}}

                        @else
                            <button type="button" class="btn btn-success disabled" style="white-space: normal">{{$student->enrollment_status}}
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        @endif
                    </td>

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
                                <br><span class="glyphicon glyphicon-ok"></span>
                            </button>
                        @else
                            <button type="button" class="btn bnt-info enabled" style="white-space: normal">Create AD Account</button>
                        @endif
                        {{--@else--}}
                        {{--<button type="button" class="btn disabled" style="white-space: normal">AD Account</button>--}}
                        {{--@endif--}}
                    </td>

                    {{--Informed Consent--}}
                    @if($button->step_id = 4)
                        <td>
                            <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                                {{$button->button_words}}
                                @if($button->button_words = "Informed Consent Given")
                                    <br></b><span class="glyphicon glyphicon-ok"></span>
                                @endif
                            </button>
                        </td>
                    @endif

                    {{--Course selection --}}
                    @if($button->step_id = 5)
                        <td>
                            <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                                {{$button->button_words}}
                                @if($button->button_words = "Course Selection Complete")
                                    <br><span class="glyphicon glyphicon-ok"></span>
                                @endif
                            </button>
                        </td>
                    @endif

                    {{--Blue Health--}}
                    @if($button->step_id = 6)
                        <td>
                            <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                                {{$button->button_words}}
                                @if($button->button_words = "Blue Health Complete")
                                    <br><span class="glyphicon glyphicon-ok"></span>
                                @endif
                            </button>
                        </td>
                    @endif

                    {{--Orientation email--}}
                    @if($button->step_id = 7)

                        <td>
                            <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                                {{$button->button_words}}
                            </button>
                            {{--need to figure out the column in DB to check for this data still (if complete)--}}
                            {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                            {{--<button type="button" class="btn btn-info enabled" style="white-space: normal">Send Orientation Email</button> </td>--}}
                            {{--@else--}}
                            {{--<button type="button" class="btn disabled" style="white-space: normal">Resend Orientation Email</button> </td>--}}
                            {{--@endif--}}
                        </td>
                        @endif


                        {{--Head Prefect Email--}}
                        @if($button->step_id = 8)

                            <td>
                                <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                                    {{$button->button_words}}
                                </button>
                                {{--need to figure out the column in DB to check for this data still (if complete)--}}
                                {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                                {{--<button type="button" class="btn b btn-info enabled" style="white-space: normal">Send Head Prefect Email</button> </td>--}}
                                {{--@else--}}
                                {{--<button type="button" class="btn disabled" style="white-space: normal">Resend Head Prefect Email</button> </td>--}}
                                {{--@endif--}}
                            </td>
                            @endif

                    @endif

                @endforeach

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center">

        {{ $students->links() }}

    </div>

@endsection
