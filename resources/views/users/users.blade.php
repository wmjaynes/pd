@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            User: {{$user->id}} : {{$user->name}} : {{$user->email}}
        </h3>
        <hr>

        @include('errors._errors')


        <ul>
            @foreach($user->organizations as $org)
                <li>{{$org->name}}</li>
            @endforeach
        </ul>
<hr>
        <ul>
            @foreach($user->organizationRoleUsers as $oru)
                <li>User: {{$oru->user->id}} : {{$oru->user->name}} : {{$oru->user->email}}</li>
                <li>Org: {{$oru->organization->id}} : {{$oru->organization->name}}</li>
                <li>Role: {{$oru->role->name}}</li>
            @endforeach
        </ul>

    </div>


@endsection
