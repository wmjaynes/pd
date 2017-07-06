@extends('layouts.app')

<script src="{{ asset('js/date.js') }}"></script>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Make copies of event: {{ $event->name }} - {{$event->startDate}}</div>
                    <hr>

                    <div class="panel-body">

                        {!! Form::open(['route'=>['events.copyStore', $event->id]]) !!}
                        <fieldset class='form-group'>
                            <div class="form-group row">
                                {!! Form::label('ncopies', 'Number of copies', ['class'=>'form-control-label col-sm-3']) !!}
                                {!! Form::select('ncopies', [1,2,3,4,5,6,7,8,9,10,11,12], ['class'=>'form-control col-sm-3']) !!}
                            </div>
                            <div class="form-group row">
                                {!! Form::label('interval', 'Separated by', ['class'=>'form-control-label col-sm-3']) !!}
                                {!! Form::select('interval', ['0' => "Doesn't matter",'1' => 'Week', '2' => 'Month'], ['class'=>'form-control col-sm-3']) !!}
                            </div>
                            <div class="form-group row bootstrap-timepicker timepicker">
                                {!! Form::label('startDate', 'Starting on', ['class'=>'form-control-label col-sm-3']) !!}
                                {!! Form::text('startDate', null, ['class'=>'form-control col-sm-3']) !!}
                            </div>
                        </fieldset>
                        {!! Form::submit("Make copy or copies", ['class'=>'btn btn-primary form-control  col-sm-10']) !!}
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $().ready(function () {
            var eventDate = moment('{{$event->startDate->format('Y-m-d')}}');
            $('#startDate').val(eventDate.format('MM/DD/YYYY'));

            $('#interval').change(function () {
                val = $(this).val();
                if (val == 1) {
                    $('#startDate').val(eventDate.clone().add(1, 'w').format('MM/DD/YYYY'));
                }
                if (val == 2) {
                    var nday = nthDayOfNextMonth(eventDate);
                    $('#startDate').val(nday.format('MM/DD/YYYY'));
                }
            });
        });


        function firstDayOfWeekOfMonth(day, aDate) {
            var theDay = aDate.clone()
                .startOf('month')
                .day(day);
            if (theDay.date() > 7) theDay.add(7, 'd');
            return theDay;
        }

        function nthdays(aday) {
            var monday = firstDayOfWeekOfMonth(aday.day(), aday);
            var month = monday.month();
            var days = [];
            var i = 0;
            var n = 0;
            while (month === monday.month()) {
                i++;
                days.push(monday.clone());
                if (aday.isSame(monday)) {
                    n = i;
                }
                monday.add(7, 'd');
            }
            return n;
        }

        function nthDayOfNextMonth(aday) {
            var n = nthdays(aday);
            var day = aday.day();
            var aDayInNextMonth = aday.clone().add(1, 'M');
            var monday = firstDayOfWeekOfMonth(day, aDayInNextMonth);
            for (i=1; i<n; i++ ){
                monday.add(7, 'd');
            }
            return monday;
        }

    </script>

@endsection
