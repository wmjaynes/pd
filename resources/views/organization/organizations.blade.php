@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            <button type="button" class="btn btn-secondary"><a href="{{route("organization.create")}}">Add
                    new
                    Organization</a>

            </button>
        </h3>

        <hr>

        @include('errors._errors')

        @if($organizations)
            <p>{{count($organizations)}} Organizations</p>
            <ul>
                @foreach($organizations as $organization)
                    @php($route = route("organization.destroy",['$organization'=> $organization->id]))
                    <li>

                        <button type="button" class="btn btn-secondary">
                            <a href="/organization/{{$organization->id }}/edit">Edit</a>
                        </button>
                        <button type="button" class="btn btn-secondary" data-toggle='modal'
                                data-target='#delete-modal' data-deleteid='{{$organization->id}}'
                                data-deletename='{{$organization->name}}'
                                data-deleteModalLabel='Delete Organization' data-route="{{$route}}">
                            Delete
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <a href="/eventsfor/{{$organization->id }}">Events</a>
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <a href="/aggregate/{{$organization->id }}">Aggregates</a>
                        </button>

                        {{$organization->id}} : {{$organization->name}}

                    </li>

                @endforeach
            </ul>
        @else
            <p>No records found.</p>
        @endif


    </div>


    @include("_deleteModal")




@endsection
