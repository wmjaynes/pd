@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            {{ Auth::user()->activeOrganization()->name }}</h3>
        <hr>

        <div class='row'>
            <div class='col-md-6'>
                <p>{{$organization->name}} displays events from the following organizations:</p>

                {!! Form::open(['route' => ['aggregate.destroy', $organization->id], 'method' => 'delete'])  !!}

                    <input type='hidden' name='orgId' value='{{$organization->id}}'>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" value='remove' name='remove' class="btn btn-primary btn-sm">Remove Selected</button>
                        </div>
                    </div>

                    @foreach($organization->aggregatees as $agg)
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
                <form action='/aggregates-search' method='post'>
                    <input type='hidden' name='orgId' value='{{$organization->id}}'>

                    <fieldset class='form-group row'>
                        <legend>Search:</legend>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-form-label">Name</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="name" id="name" value='' required>
                            </div>
                            <button type="submit" value='search' name='search' class="btn btn-primary btn-sm">Search</button>

                        </div>

                        @foreach($searchOrgs as $agg)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name='addOrg[]' value="{{$agg->id}}">
                                {{$agg->id}}: {{$agg->name}} ({{$agg->city}})
                            </label>
                        </div>
                        @endforeach

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" value='addnew' name='addnew' class="btn btn-primary btn-sm">Add Selected</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>



@endsection
