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
                            Organization: {{ Auth::user()->currentOrganization->name }}</h3>

                        <div class="form-status-holder">
                            @include('errors._errors')
                        </div>

                        {!! Form::open(['route'=>'events.store']) !!}

                        @include('events._form', ['submitButtonText' => 'Create Event'])

                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
