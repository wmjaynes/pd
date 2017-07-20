@extends('layouts.app')

@section('content')
    <div class="container">
        <p>
            Venues are named locations where events take place. You may create a new venue and use it immediately,
            however, if it proves to be a duplicate of an already existing venue it will be removed from the list.
        </p>
        <ul>
            <li>Venue must have a name, city, and state.</li>
            <li>Duplicates are not allowed, so check the list below carefully before creating a new venue.</li>
            <li>You may create a special venue "Call for location" for your city and state, if this is necessary.</li>
            <li>If necessary the address could be the cross streets, e.g. "Main and Washington, Ann Arbor, MI"</li>
            <li>Venues can be complicated. A specific address may not be enough to specify the exact location of an
                event. This is why each event has space for venue details, so event specific details for a venue can be
                added for each event. Such specifics could be "Room #235" or "Parking Lot F". <strong>Please do not
                    create a venue with such details.</strong>
            </li>
        </ul>

        <p>
            <button type="button" class="btn btn-secondary"><a href="{{route("venue.create")}}">Add new Venue</a>
            </button>
        </p>

        <hr>

        @include('errors._errors')

        @if($venues)
            <p>{{count($venues)}} Venues</p>
            <table class="table table-sm">
                <thead class="thead-default">
                <tr>
                    @if(Auth::user()->superuser)
                        <th></th>
                        <th></th>
                    @endif
                    <th>Venue ID</th>
                    <th>Venue Name</th>
                    <th>City - State</th>
                    <th># of Events</th>
                </tr>
                </thead>
                <tbody>

                @foreach($venues as $venue)
                    @php($route = route("venue.destroy",['$venue'=> $venue->id]))
                    <tr>
                        @if(Auth::user()->superuser)
                            <td>
                                <button type="button" class="btn btn-secondary">
                                    <a href="/venue/{{$venue->id }}/edit">Edit</a>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-secondary" data-toggle='modal'
                                        data-target='#delete-modal' data-deleteid='{{$venue->id}}'
                                        data-deletename='{{$venue->name}}'
                                        data-deleteModalLabel='Delete Venue' data-route="{{$route}}">
                                    Delete
                                </button>
                            </td>
                        @endif
                        <td>{{$venue->id}}</td>
                        <td>{{$venue->name}}</td>
                        <td>{{$venue->addressLocality}}, {{$venue->addressRegion}}</td>
                        <td>{{$venue->events->count()}}</td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        @else
            <p>No records found.</p>
        @endif


    </div>


    @include("_deleteModal")




@endsection
