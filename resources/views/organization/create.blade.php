@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="panel panel-default">
            <div class="panel-heading">Organizations</div>


            <h3>User: {{ Auth::user()->nameOrEmail() }}
                Organization: {{ Auth::user()->activeOrganization()->name }}</h3>

            <div class="form-status-holder">
                @include('events._errors')
            </div>

            {!! Form::open(['route'=>'organization.store']) !!}

            @include('organization._form', ['submitButtonText' => 'Create Organization'])

            {!! Form::close() !!}


        </div>


    </div>




@endsection
