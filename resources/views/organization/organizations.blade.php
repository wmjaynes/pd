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

        @if($organizations)
            <ul>
                @foreach($organizations as $organization)
                    <li>
                        <a href="{{ route('organization.edit', ['organization'=>$organization->id]) }}">{{$organization->name}}</a>
                    </li>

                @endforeach
            </ul>
        @else
            <p>No records found.</p>
        @endif


    </div>






@endsection
