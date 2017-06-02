@extends('layouts.app')



@section('content')

    <script type="text/javascript" src="/js/date.js"></script>


    <script type="text/javascript">
        $().ready(function () {

            /*
             $("#eventForm").validate();
             */

            $('#startDate').keyup(function () {
                if ($(this).val().length < 5)
                    return;
                dt = Date.parse($(this).val());
                if (dt == null)
                    str = "Not a valid date";
                else
                    str = "Date is " + dt.toString('M/d/yy h:mm tt');
                $("#startDate-carbon").html(str);
            });
            $('#startDate').blur(function () {
                dt = $("#startDate-carbon").html();
                dt = dt.replace("Date is ", "");
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
                    <div class="panel-heading">Edit Event: {{$event->id}}</div>


                    <div class="panel-body">
                        <h3>User: {{ Auth::user()->nameOrEmail() }}
                            Organization: {{ Auth::user()->activeOrganization()->name }}</h3>

                        <div class="form-status-holder"></div>
                        <form id="eventForm" class='autosave-form' action='/events/{{$event->id}}' method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type='hidden' name='eventId' value='{{$event->id}}'>


                            <fieldset class='form-group row'>
                                <legend>Approval:</legend>
                                <div>When you first create an event, we 'hide' it from the public until you are ready to
                                    release it.
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label col-sm-2">Approval</label>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="published" name="published"
                                                   value='1'{{ $event->published ? 'checked' : ''}}>
                                            Show
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="published" name="published"
                                                   value='0'{{ $event->published ? '' : 'checked'}}>
                                            Hide</label>
                                    </div>
                                </div>
                            </fieldset>


                            <fieldset class='form-group row'>
                                <legend>Date and Time:</legend>
                                <div class="form-group row">
                                    <label for="eventName" class="col-sm-2 control-form-label"> Event Name </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="eventName" id="eventName"
                                               value='{{$event->name}}' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="startDate" class="col-sm-2 control-form-label"> Start Date/Time </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="startDate" name="startDate"
                                               placeholder="e.g. 2/1/17 8pm" value='{{$event->startDate}}'
                                               required
                                        >
                                        <div id='startDate-carbon'></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="endDate" class="col-sm-2 control-form-label"> End Date/Time </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name='endDate' id="endDate"
                                               placeholder="e.g. 2/1/17 10pm" value='{{$event->endDate}}' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="timeInfo" class="col-sm-2 control-form-label">Time Details </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name='timeInfo' id="timeInfo"
                                               placeholder='e.g. Beginner instruction at 7:30'
                                               value='{{$event->timeInfo}}'
                                        >
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class='form-group row'>
                                <legend>Describe the event:</legend>
                                <div class='form-group row'>
                                    <label for="description" class="col-sm-2 control-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" id="description"
                                                  name="description">{{ $event->description }}</textarea>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class='form-group row'>
                                    <legend>Admission (tickets, registration, admission info):</legend>
                                <div class='form-group row'>
                                    <label for="ticketInfo" class="col-sm-2 control-form-label">&nbsp</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" id="ticketInfo"
                                                  name="ticketInfo">{{ $event->ticketInfo }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contactName" class="col-sm-2 control-form-label"> Contact Name </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="contactName" name="contactName"
                                               value='{{$event->contactName}}'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 control-form-label">Contact Phone </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name='phone' id="phone"
                                               value='{{$event->phone}}'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 control-form-label"> Contact Email</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name='email' id="email"
                                               value='{{$event->email}}'>
                                    </div>
                                </div>
                            </fieldset>


                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
