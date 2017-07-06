@extends('layouts.app')



@section('content')

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
