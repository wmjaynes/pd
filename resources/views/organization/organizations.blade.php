@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            <button type="button" class="btn btn-secondary"><a href="{{route("organization.create")}}">Add
                    new
                    Organization</a>

            </button>
            {{ Auth::user()->activeOrganization()->name }}</h3>

        <hr>

        @include('errors._errors')

        @if($organizations)
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

                        {{$organization->name}}

                    </li>

                @endforeach
            </ul>
        @else
            <p>No records found.</p>
        @endif


    </div>


    @include("_deleteModal")




@endsection
