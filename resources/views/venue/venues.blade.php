@extends('layouts.app')

@section('content')
    <div class="container">

        <h3>
            <button type="button" class="btn btn-secondary"><a href="{{route("venue.create")}}">Add new Venue</a>
            </button>
        </h3>

        <hr>

        @include('errors._errors')

        @if($venues)
            <p>{{count($venues)}} Venues</p>
            <ul>
                @foreach($venues as $venue)
                    @php($route = route("venue.destroy",['$venue'=> $venue->id]))
                    <li>

                        <button type="button" class="btn btn-secondary">
                            <a href="/venue/{{$venue->id }}/edit">Edit</a>
                        </button>
                        <button type="button" class="btn btn-secondary" data-toggle='modal'
                                data-target='#delete-modal' data-deleteid='{{$venue->id}}'
                                data-deletename='{{$venue->name}}'
                                data-deleteModalLabel='Delete Venue' data-route="{{$route}}">
                            Delete
                        </button>

                        {{$venue->id}} : {{$venue->name}} : {{$venue->addressLocality}} : #events - {{$venue->events->count()}}

                    </li>

                @endforeach
            </ul>
        @else
            <p>No records found.</p>
        @endif


    </div>


    @include("_deleteModal")




@endsection
