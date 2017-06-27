@extends('layouts.app')

@section('content')
    <div class="container">


        <h3>
            User: {{$user->id}} : {{$user->name}} : {{$user->email}}
        </h3>
        <hr>

        <p> Organization: {{$organization->name}}
        </p>
        <div class='row'>
            <div class='col-md-6'>
                <p>The following users are either editors or administrators for {{$organization->name}}.
                <ul>
                    <li>Editors may create and edit any events for an organization.</li>
                    <li>Administrators are editors and, in addition, may add other users as editors or administrators.
                    </li>
                </ul>
                </p>

                @include('errors._errors')

                {!! Form::open(['route' => ['administer.org.destroy', $organization->id], 'method' => 'delete'])  !!}

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" value='remove' name='remove' class="btn btn-primary btn-sm">Remove
                            Selected
                        </button>
                    </div>
                </div>

                @foreach($organization->users()->get() as $uuser)
                    @php($user->id == $uuser->id ? $disabled="disabled='disabled'" : $disabled="")
                    @php($user->id == $uuser->id ? $title="You can not delete yourself.":$title="")
                    <div class="checkbox">
                        <label title="{{$title}}">
                                <input type="checkbox" name='delUser[]' value="{{$uuser->id}}" {{$disabled}}>
                            {{$uuser->id}}: {{$uuser->name}} ({{$uuser->email}}) ({{$uuser->pivot->role->name}})
                        </label>
                    </div>
                @endforeach
                {!! Form::close()  !!}

            </div>
            <div class='col-md-6'>
                <p>Search for users you would like to add as an editor or administrator:</p>

                {!! Form::open(['route' => ['administer.org.search', $organization->id]]) !!}

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

                    @if($searchUsers)
                        {!! Form::open(['route' => ['administer.org.update', $organization->id], 'method' => 'patch']) !!}
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" value='addeditor' name='addnew' class="btn btn-primary btn-sm">Add
                                    Selected as Editor
                                </button>
                                <button type="submit" value='addadministrator' name='addnew'
                                        class="btn btn-primary btn-sm">Add
                                    Selected as Administrator
                                </button>
                            </div>
                        </div>
                        @foreach($searchUsers as $user)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name='addUser[]' value="{{$user->id}}">
                                    {{$user->id}}: {{$user->name}} ({{$user->email}})
                                </label>
                            </div>
                        @endforeach
                        {!! Form::close() !!}
                    @else()
                        <p class="alert">{{isset($message)?$message:""}}</p>
                @endif

            </div>
        </div>

    </div>


@endsection
