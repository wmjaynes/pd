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
                    User: {{Auth::user()->nameOrEmail()}}
                    <br>
                    Organization: {{Auth::user()->organization()->name}}
                    <br>
                    OrganizationRoleUser: {{ Auth::user()->organizationRoleUsers()->first() }}
                    <br>
                    User: {{$usr}}
                    <br>
                    <br>
                    User Role: {{ Auth::user()->organizationRoleUsers()->first()->role }}
                    <br>
                    <br>
                    User Org: {{ Auth::user()->organizationRoleUsers()->first()->organization }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
