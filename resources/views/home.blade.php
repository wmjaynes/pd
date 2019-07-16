@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            You are logged in!
        </div>
        <div class="panel-body">
            <p>User: {{Auth::user()->nameOrEmail()}}</p></p><p>Currently active
                organization: {{isset($currentOrganization) ? $currentOrganization->name : "None"}}</p>

            @if(Auth::user()->getApprovedOrganizations->isEmpty())
                <p>You do not have any organizations for which you can add events. Please contact <strong>events@aactmad
                        .org</strong> and indicate the organization(s) with which you would like to be associated.</p>
            @else
                <p>Below are organizations for which you can create events. Click on one to create events for it:
                <ul>
                    @foreach(Auth::user()->getApprovedOrganizations as $org)
                        <li>
                            <a href="{{route('eventsfor.show',['organization'=>$org->id])}}">{{ $org->name }}</a> :
                            {{$org->pivot->create_at}}
                            :
                            {{$org->pivot->approved}}
                        </li>

                    @endforeach
                </ul>
            @endif

            <choose-organizations-component></choose-organizations-component>

            <hr>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Organizations for which you may publish events</h5>
                            <ul class="list-group list-group-flush">
                                @foreach(Auth::user()->getApprovedOrganizations as $org)
                                    <li class="list-group-item">
                                        <a href="{{route('eventsfor.show',['organization'=>$org->id])}}">{{ $org->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Organizations for which you may create, but not yet publish events</h5>
                            <ul class="list-group list-group-flush">
                                @foreach(Auth::user()->getUnapprovedOrganizations as $org)
                                    <li class="list-group-item">
                                        <a href="{{route('eventsfor.show',['organization'=>$org->id])}}">{{ $org->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">

                </div>
            </div>
            <br> <br> <br>

        </div>
    </div>
@endsection
