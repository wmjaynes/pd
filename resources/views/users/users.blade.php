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
            @foreach($user->organizations as $org)
                <li>
                    <a href="{{route('eventsfor.show',['organization'=>$org->id])}}">{{ $org->name }}</a> :
                    {{$org->pivot->role->name}}
                </li>

            @endforeach
        </ul>

    </div>


@endsection
