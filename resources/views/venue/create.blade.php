@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>User: {{ Auth::user()->nameOrEmail() }}
            Organization: {{ Auth::user()->currentOrganization->name }}</h3>

        <div class="form-status-holder">
            @include('errors._errors')
        </div>

    {!! Form::open(['route'=>'venue.store']) !!}

    @include('venue._form', ['submitButtonText' => 'Create Venue'])

    {!! Form::close() !!}


@endsection
