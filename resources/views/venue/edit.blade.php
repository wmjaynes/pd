@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>User: {{ Auth::user()->nameOrEmail() }}
            Organization: {{ Auth::user()->currentOrganization->name }}</h3>

        <div class="form-status-holder">
            @include('errors._errors')
        </div>

    {!! Form::model($venue, ['method' => 'patch', 'route'=>['venue.update', $venue->id]]) !!}

    @include('venue._form', ['submitButtonText' => 'Update Venue'])

    {!! Form::close() !!}


@endsection
