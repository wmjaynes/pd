@extends('layouts.app')

@section('content')
    <div class="container">


        <p>
            <a href="{{route("organization.create")}}" class="btn btn-primary">Add new Organization</a>
        </p>

        <hr>

        @include('errors._errors')

        @if($myOrganizations->isNotEmpty())
            <p>Your {{count($myOrganizations)}} Organizations</p>
            <table class="table table-sm">
                <thead class="thead-default">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th># of Events</th>
                </tr>
                </thead>
                <tbody>
                @foreach($myOrganizations as $organization)
                    @php($route = route("organization.destroy",['$organization'=> $organization->id]))

                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name='org[]' value="{{$organization->id}}">
                                </label>
                            </div>
                        </td>

                        <td>
                            <a href="/organization/{{$organization->id }}/edit" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <a href="/administer/{{$organization->id }}" class="btn btn-outline-secondary btn-sm">Administer</a>
                            <a href="/aggregate/{{$organization->id }}" class="btn btn-outline-secondary btn-sm">Aggregates</a>
                            <a href="/eventsfor/{{$organization->id }}" class="btn btn-outline-secondary btn-sm">Events</a>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle='modal'
                                    data-target='#delete-modal' data-deleteid='{{$organization->id}}'
                                    data-deletename='{{$organization->name}}'
                                    data-deleteModalLabel='Delete Organization' data-route="{{$route}}">
                                Delete
                            </button>
                        </td>
                        <td>{{$organization->name}}
                        </td>
                        <td>{{$organization->events->count()}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        @else
            <p>You have no organizations that you can administer or edit.</p>
        @endif

        <hr>

        @if($allOrganizations)
            <p>All {{count($allOrganizations)}} Organizations</p>
        {!! Form::open() !!}
            <table class="table table-sm">
                <thead class="thead-default">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th># of Events</th>
                </tr>
                </thead>
                <tbody>
                @foreach($allOrganizations as $organization)
                    @php($route = route("organization.destroy",['$organization'=> $organization->id]))

                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name='org[]' value="{{$organization->id}}">
                                </label>
                            </div>
                        </td>

                        @if(Auth::user()->superuser)
                            <td>
                                <a href="/organization/{{$organization->id }}/edit" class="btn btn-outline-secondary btn-sm">Edit</a>
                                <a href="/administer/{{$organization->id }}" class="btn btn-outline-secondary btn-sm">Administer</a>
                                <a href="/aggregate/{{$organization->id }}" class="btn btn-outline-secondary btn-sm">Aggregates</a>
                                <a href="/eventsfor/{{$organization->id }}" class="btn btn-outline-secondary btn-sm">Events</a>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle='modal'
                                        data-target='#delete-modal' data-deleteid='{{$organization->id}}'
                                        data-deletename='{{$organization->name}}'
                                        data-deleteModalLabel='Delete Organization' data-route="{{$route}}">
                                    Delete
                                </button>
                            </td>
                        @endif
                        <td>{{$organization->name}}
                        </td>
                        <td>{{$organization->events->count()}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {!! Form::close() !!}
        @else
            <p>No records found.</p>
        @endif


    </div>


    @include("_deleteModal")




@endsection
