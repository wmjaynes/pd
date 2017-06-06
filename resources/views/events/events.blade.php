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
                            {{ Auth::user()->activeOrganization()->name }}</h3>

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
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-secondary">
                                                <a href="/events/{{$event->id }}/edit">Edit</a>
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-toggle='modal'
                                                    data-target='#delete-modal' data-eventid='{{$event->id}}'
                                                    data-eventname='{{$event->name}}'>
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
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-secondary">
                                                <a href="/events/{{$event->id }}/edit">Edit</a>
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-toggle='modal'
                                                    data-target='#delete-modal' data-eventid='{{$event->id}}'
                                                    data-eventname='{{$event->name}}'>
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


    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Delete the event: <span id="eventname"></span> ? This action can not be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    {{ Form::open(['route' => ['events.destroy', $event->id], 'method' => 'delete', 'class' => 'destroy-form']) }}
                    <button type="submit" class="btn btn-danger">Delete</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#delete-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var eventid = button.data('eventid') // Extract info from data-* attributes
            var eventname = button.data('eventname')
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find("#eventname").html(eventname);
            var dform = modal.find('.destroy-form')
            var destroylink = '{{ route("events.destroy",['event'=> 'destroyid']) }}';
            destroylink = destroylink.replace('destroyid', eventid);
            dform.attr('action', destroylink);
        });
    </script>

@endsection
