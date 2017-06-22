@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            User: {{$user->id}} : {{$user->name}} : {{$user->email}}
        </h3>
        <hr>

        <p> Organization: {{$organization->name}}
        </p>
        <p>The following users may administer the above organization.</p>

        @include('errors._errors')


        <ul>
            @foreach($organization->users as $user)
                <li>{{$user->nameOrEmail()}} : {{$user->pivot->role->name}}</li>
            @endforeach
        </ul>

    </div>


@endsection
