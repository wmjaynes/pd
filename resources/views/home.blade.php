@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        You are logged in!
                    </div>
                    <div class="panel-body">
                        <p>User: {{Auth::user()->nameOrEmail()}}</p>
                        </p>
                        <p>Currently active
                            organization: {{isset($currentOrganization) ? $currentOrganization->name : "None"}}</p>

                        @if(Auth::user()->organizations->isEmpty())
                            <p>You do not have any organizations for which you can add events. Please contact <strong>events@aactmad
                                    .org</strong> and indicate the organization(s) with which you would like to be associated.</p>
                        @else
                            <p>Organizations for which you can create events:
                            <ul>
                                @foreach(Auth::user()->organizations as $org)
                                    <li>
                                        <a href="{{route('eventsfor.show',['organization'=>$org->id])}}">{{ $org->name }}</a>
                                        :
                                        {{$org->pivot->role->name}}
                                    </li>

                                @endforeach
                            </ul>
                        @endif
                        <br>
                        <br>
                        <br>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
