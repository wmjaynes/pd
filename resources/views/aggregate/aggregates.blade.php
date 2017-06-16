@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            {{ session('currentOrganization')->name }}</h3>
        <hr>

        <div class='row'>
            <div class='col-md-6'>
                <p>{{session('currentOrganization')->name}} displays events from the following organizations:</p>

                {!! Form::open(['route' => ['aggregate.destroy', $organization->id], 'method' => 'delete'])  !!}

                <input type='hidden' name='orgId' value='{{$organization->id}}'>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" value='remove' name='remove' class="btn btn-primary btn-sm">Remove
                            Selected
                        </button>
                    </div>
                </div>

                @foreach($organization->aggregateesNotMe() as $agg)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name='agg[]' value="{{$agg->id}}">
                            {{$agg->id}}: {{$agg->name}} ({{$agg->city}})
                        </label>
                    </div>
                @endforeach
                {!! Form::close()  !!}
            </div>
            <div class='col-md-6'>
                <p>Search for organizations you would like to add:</p>

                {!! Form::open(['route' => ['aggregate.search', $organization->id]]) !!}
                <input type='hidden' name='orgId' value='{{$organization->id}}'>

                <fieldset class='form-group row'>
                    <legend>Search:</legend>
                    <div class="form-group row">
                        <label for="name" class="col-md-2 control-form-label">Name</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="searchTerm" id="searchTerm"
                                   value='{{$searchTerm or null}}' required>
                        </div>
                        <button type="submit" value='search' name='search' class="btn btn-primary btn-sm">Search
                        </button>

                    </div>
                    {!! Form::close() !!}

                    @if($searchOrgs)
                        {!! Form::open(['route' => ['aggregate.search', $organization->id], 'method' => 'patch']) !!}
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" value='addnew' name='addnew' class="btn btn-primary btn-sm">Add
                                    Selected
                                </button>
                            </div>
                        </div>
                        @foreach($searchOrgs as $agg)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name='addOrg[]' value="{{$agg->id}}">
                                    {{$agg->id}}: {{$agg->name}} ({{$agg->city}})
                                </label>
                            </div>
                        @endforeach
                        {!! Form::close() !!}
                    @else()
                        <p class="alert">No results found</p>
                @endif

            </div>
        </div>



@endsection
