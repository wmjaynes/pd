@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>User: {{ Auth::user()->nameOrEmail() }}
            Organization: {{ Auth::user()->activeOrganization()->name }}</h3>

        <div class="form-status-holder">
            @include('errors._errors')
        </div>

    {!! Form::model($organization, ['method' => 'patch', 'route'=>['organization.update', $organization->id]]) !!}

    @include('organization._form', ['submitButtonText' => 'Update Organization'])

    {!! Form::close() !!}


@endsection
