@extends('layouts.app')



@section('content')

    <script type="text/javascript" src="/js/date.js"></script>


    <script type="text/javascript">
        $().ready(function () {

            /*
             $("#eventForm").validate();
             */

            $('#startDate').keyup(function () {
                if ($(this).val().length < 1)
                    return;
                dt = Date.parse($(this).val());
                if (dt == null)
                    str = "Not a valid date and time";
                else
                    str = "Date is " + dt.toString('M/d/yy h:mm tt');
                $("#startDate-carbon").html(str);
            });
            $('#endDate').keyup(function () {
                if ($(this).val().length < 1)
                    return;
                dt = Date.parse($(this).val());
                if (dt == null)
                    str = "Not a valid date and time";
                else
                    str = "Date is " + dt.toString('M/d/yy h:mm tt');
                $("#endDate-carbon").html(str);
            });
            $('#startDate').blur(function () {
                dt = $("#startDate-carbon").html();
                if (dt) {
                    dt = dt.replace("Date is ", "");
                    $(this).val(dt);
                }
                endDateField = $('#endDate');

                if (endDateField.val() == "") {
                    endDt = Date.parse(dt).add(3).hours();
                    endDateField.val(endDt.toString('M/d/yy h:mmtt'));
                    $(this).val(dt);
                }
                $("#startDate-carbon").html("");
            });
        });
    </script>




    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Event:</div>


                    <div class="panel-body">
                        <h3>User: {{ Auth::user()->nameOrEmail() }}
                            Organization: {{ Auth::user()->activeOrganization()->name }}</h3>

                        <div class="form-status-holder"></div>
                        {!! Form::open(['route'=>'events.store']) !!}

                        <fieldset class='form-group'>
                            <legend>Approval:</legend>
                            <div>When you first create an event, we 'hide' it from the public until you are ready to
                                release it.
                            </div>

                            <div class="form-check form-check-inline">
                                <label class="form-check-label">Approval</label>

                                <div class="form-check form-check-inline">
                                    {!! Form::label('published', 'Show', ['class'=>'form-check-label']) !!}
                                    {!! Form::radio('published', 1, ['class'=>'form-check-input']) !!}
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::label('published', 'Hide', ['class'=>'form-check-label']) !!}
                                    {!! Form::radio('published', 0, ['class'=>'form-check-input']) !!}
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class='form-group'>
                            <legend>Date and Time:</legend>
                            <div class="form-group row">
                                {!! Form::label('name', 'Event Name', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('name', null, ['class'=>'form-control col-sm-6']) !!}
                            </div>
                            <div class="form-group row">
                                {!! Form::label('startDate', 'Start Date/Time', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('startDate', null, ['class'=>'form-control col-sm-4','placeholder'=>'e.g. 2/1/17 8pm']) !!}
                                <div id='startDate-carbon'></div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('endDate', 'Ending Date/Time', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('endDate', null, ['class'=>'form-control col-sm-4','placeholder'=>'e.g. 2/1/17 10pm']) !!}
                                <div id='endDate-carbon'></div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('timeInfo', 'Time Details', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('timeInfo', null, ['class'=>'form-control col-sm-8','placeholder'=>'e.g. Beginner instruction at 7:30']) !!}
                            </div>
                        </fieldset>

                        <fieldset class='form-group'>
                            <legend>Describe the event:</legend>
                            <div class="form-group row">
                                {!! Form::label('description', 'Description', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::textarea('description', null, ['class'=>'form-control col-sm-6']) !!}
                            </div>
                        </fieldset>

                        <fieldset class='form-group'>
                            <legend>Admission (tickets, registration, admission info):</legend>
                            <div class="form-group row">
                                {!! Form::label('ticketInfo', ' ', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::textarea('ticketInfo', null, ['class'=>'form-control col-sm-6']) !!}
                            </div>
                            <div class="form-group row">
                                {!! Form::label('contactName', 'Contact Name', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('contactName', null, ['class'=>'form-control col-sm-6']) !!}
                            </div>
                            <div class="form-group row">
                                {!! Form::label('phone', 'Contact Phone', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('phone', null, ['class'=>'form-control col-sm-6']) !!}
                            </div>
                            <div class="form-group row">
                                {!! Form::label('email', 'Contact Email', ['class'=>'form-control-label col-sm-2']) !!}
                                {!! Form::text('email', null, ['class'=>'form-control col-sm-6']) !!}
                            </div>
                        </fieldset>


                        <div class="form-group row">
                            {!! Form::submit('Save', ['class'=>'btn btn-primary form-control offset-sm-2 col-sm-10']) !!}
                        </div>
                        {!! Form::close() !!}

                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
