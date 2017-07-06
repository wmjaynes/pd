@extends('layouts.app')



@section('content')

    <script type="text/javascript" src="/js/date.js"></script>


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Event: {{$event->id}}</div>


                    <div class="panel-body">
                        <h3>User: {{ Auth::user()->nameOrEmail() }}
                            Organization: {{ Auth::user()->currentOrganization->name }}</h3>

                        <div class="form-status-holder">
                            @include('errors._errors')
                        </div>
                        {!! Form::model($event, ['method' => 'patch', 'route'=>['events.update', $event->id]]) !!}

                        @include('events._form', ['submitButtonText' => 'Update Event'])

                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
