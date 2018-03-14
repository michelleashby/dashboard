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
                        <button type="button" class="btn btn-success disabled" aria-label="done">
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
                    {{--getValidationButton($student)--}}
                    <button type="button" class="{{$button->button_class}}" style="white-space: normal">
                    {{$button->button_words}}
                    {{--@if($button->button_words = "Validation Complete")--}}
                    {{--<span class="glyphicon glyphicon-ok"></span>--}}
                    {{--@endif--}}
                    </button>
                    </td>



                    {{--data validation--}}
                    {{--@if($student->custom_field_1 = "Yes")--}}
                    {{--@if($button->step_id = 1)--}}
                        {{--<td>--}}
                            {{--getValidationButton($student)--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                                {{--@if($button->button_words = "Validation Complete")--}}
                                    {{--<span class="glyphicon glyphicon-ok"></span>--}}
                                {{--@endif--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}

                    {{--student-type--}}
                    {{--will want this to flag if it changes for some reason... may be advanced function (wish list)--}}
                    {{--<td>{{$student->student_type}}</td>--}}

                    {{--Enrollment check--}}
                    {{--@if($button->step_id = 2)--}}
                        {{--<td>--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                                {{--@if($button->button_words = "AD Account Exists")--}}
                                    {{--<br></b><span class="glyphicon glyphicon-ok"></span>--}}
                                {{--@endif--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}

                    {{--deposit received--}}
                    {{--<td>--}}
                        {{--@if($student->deposit_received = "Yes")--}}
                            {{--<button type="button" class="btn btn-success disabled" aria-label="done">--}}
                                {{--<span class="glyphicon glyphicon-ok "></span></button>--}}
                        {{--@else--}}
                            {{--<button type="button" class="btn" aria-label="done">--}}
                                {{--<span class="glyphicon glyphicon-remove"></span></button>--}}
                        {{--@endif--}}

                    {{--</td>--}}

                    {{--AD account check--}}
                    {{--@if($button->step_id = 3)--}}
                        {{--<td>--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                                {{--@if($button->button_words = "AD Account Exists")--}}
                                    {{--<br></b><span class="glyphicon glyphicon-ok"></span>--}}
                                {{--@endif--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}


                    {{--Informed Consent--}}
                    {{--@if($button->step_id = 4)--}}
                        {{--<td>--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                                {{--@if($button->button_words = "Informed Consent Given")--}}
                                    {{--<br></b><span class="glyphicon glyphicon-ok"></span>--}}
                                {{--@endif--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}

                    {{--Course selection --}}
                    {{--@if($button->step_id = 5)--}}
                        {{--<td>--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                                {{--@if($button->button_words = "Course Selection Complete")--}}
                                    {{--<br><span class="glyphicon glyphicon-ok"></span>--}}
                                {{--@endif--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}

                    {{--Blue Health--}}
                    {{--@if($button->step_id = 6)--}}
                        {{--<td>--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                                {{--@if($button->button_words = "Blue Health Complete")--}}
                                    {{--<br><span class="glyphicon glyphicon-ok"></span>--}}
                                {{--@endif--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}

                    {{--Orientation email--}}
                    {{--@if($button->step_id = 7)--}}

                        {{--<td>--}}
                            {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                {{--{{$button->button_words}}--}}
                            {{--</button>--}}
                            {{--need to figure out the column in DB to check for this data still (if complete)--}}
                            {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                            {{--<button type="button" class="btn btn-info enabled" style="white-space: normal">Send Orientation Email</button> </td>--}}
                            {{--@else--}}
                            {{--<button type="button" class="btn disabled" style="white-space: normal">Resend Orientation Email</button> </td>--}}
                            {{--@endif--}}
                        {{--</td>--}}
                        {{--@endif--}}


                        {{--Head Prefect Email--}}
                        {{--@if($button->step_id = 8)--}}

                            {{--<td>--}}
                                {{--<button type="button" class="{{$button->button_class}}" style="white-space: normal">--}}
                                    {{--{{$button->button_words}}--}}
                                {{--</button>--}}
                                {{--need to figure out the column in DB to check for this data still (if complete)--}}
                                {{--@if($student->custom_field_9 = "Yes" && $student->custom_field_2 != null)--}}
                                {{--<button type="button" class="btn b btn-info enabled" style="white-space: normal">Send Head Prefect Email</button> </td>--}}
                                {{--@else--}}
                                {{--<button type="button" class="btn disabled" style="white-space: normal">Resend Head Prefect Email</button> </td>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            {{--@endif--}}

                @endforeach
                {{--@endif--}}

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center">

        {{ $students->links() }}

    </div>

@endsection
