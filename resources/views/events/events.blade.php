@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Events</div>


                    <div class="panel-body">
                        <h3>
                            <button type="button" class="btn btn-secondary"><a href="{{route("events.create")}}">Add new
                                    event for</a>

                            </button>
                            {{ session('currentOrganization')->name }}</h3>

                        <hr>
                        <a href="/events">Current</a> &nbsp;&nbsp;
                        @foreach($years as $yr)
                            <a href="/events?year={{$yr }}">{{ $yr }}</a> &nbsp;&nbsp;
                        @endforeach
                        <hr>

                        <p>
                            <strong> These events are not yet published. They are not visible to the public. </strong>
                        </p>
                        @if($hidden)
                            <table class="table">
                                <thead class='thead-default'>
                                <tr>
                                    <th>&nbsp</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($hidden as $event)
                                    @php($route = route("events.destroy",['event'=> $event->id]))
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-secondary">
                                                <a href="/events/{{$event->id }}/edit">Edit</a>
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-toggle='modal'
                                                    data-target='#delete-modal' data-deleteid='{{$event->id}}'
                                                    data-deletename='{{$event->name}}'
                                                    data-deleteModalLabel='Delete Event' data-route="{{$route}}">
                                                Delete
                                            </button>
                                        </td>
                                        <td>{{$event->startDate}}</td>
                                        <td>{{$event->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No records found.</p>
                        @endif

                        <p>
                            @if ($year)
                                <strong>Below are published events for {{$year}}.</strong>
                            @else
                                <strong>Below are published events for the future.</strong>
                            @endif
                        </p>
                        @if($events)
                            <hr>
                            <table id='published_events'
                                   class=" table table-bordered table-hover table-sm table-responsive">
                                <thead class='thead-default'>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    @php($route = route("events.destroy",['event'=> $event->id]))
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-secondary">
                                                <a href="/events/{{$event->id }}/edit">Edit</a>
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-toggle='modal'
                                                    data-target='#delete-modal' data-deleteid='{{$event->id}}'
                                                    data-deletename='{{$event->name}}'
                                                    data-deleteModalLabel='Delete Event' data-route="{{$route}}">
                                                Delete
                                            </button>
                                        </td>
                                        <td>{{$event->startDate}}</td>
                                        <td>{{ $event->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No records found.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('_deleteModal')

@endsection
