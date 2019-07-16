@extends('layouts.app')

@section('content')
    <div class="container" id="app">


        <h3>
            {{ $organization->name }}</h3>
        <hr>


        <aggregate-component v-bind:org-id="{{Auth::user()->currentOrganization->id}}"></aggregate-component>

    </div>



@endsection
