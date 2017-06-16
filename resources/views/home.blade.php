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
                        <p>Organizations for which you can create events:
                        <ul>
                            @foreach(Auth::user()->organizationRoleUsers as $oru)
                                <li>
                                    <a href="{{route('eventsfor.show',['organization'=>$oru->organization->id])}}">{{ $oru->organization->name }}</a>
                                </li>

                            @endforeach
                        </ul>
                        </p>
                        <p>Currently active organization: {{session('currentOrganization')->name}}</p>
                        <br>
                        <br>
                        <br>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
