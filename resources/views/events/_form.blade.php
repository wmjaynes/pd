<fieldset class='form-group'>
    <legend>Approval:</legend>
    <div>When you first create an event, we 'hide' it from the public until you are ready to
        release it.
    </div>

    <div class="form-check form-check-inline">
        <label class="form-check-label">Approval</label>

        <div class="form-check form-check-inline">
            {!! Form::label('published', 'Show', ['class'=>'form-check-label']) !!}
            {!! Form::radio('published', 1, ['class'=>'form-check-input']) !!}
        </div>
        <div class="form-check form-check-inline">
            {!! Form::label('published', 'Hide', ['class'=>'form-check-label']) !!}
            {!! Form::radio('published', 0, ['class'=>'form-check-input']) !!}
        </div>
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Date and Time:</legend>
    <div class="form-group row {{ $errors->has('name') ? 'alert-danger' : '' }}">
        {!! Form::label('name', 'Event Name', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('name', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
    <div class="form-group row {{ $errors->has('startDate') ? 'alert-danger' : '' }}">
        {!! Form::label('startDate', 'Start Date/Time', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('startDate', null, ['class'=>'form-control col-sm-4','placeholder'=>'e.g. 2/1/17 8pm']) !!}
        <div id='startDate-carbon'></div>
    </div>
    <div class="form-group row {{ $errors->has('endDate') ? 'alert-danger' : '' }}">
        {!! Form::label('endDate', 'Ending Date/Time', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('endDate', null, ['class'=>'form-control col-sm-4','placeholder'=>'e.g. 2/1/17 10pm']) !!}
        <div id='endDate-carbon'></div>
    </div>
    <div class="form-group row">
        {!! Form::label('timeInfo', 'Time Details', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('timeInfo', null, ['class'=>'form-control col-sm-8','placeholder'=>'e.g. Beginner instruction at 7:30']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Describe the event:</legend>
    <div class="form-group row">
        {!! Form::label('description', 'Description', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::textarea('description', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Admission (tickets, registration, admission info):</legend>
    <div class="form-group row">
        {!! Form::label('ticketInfo', ' ', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::textarea('ticketInfo', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('contactName', 'Contact Name', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('contactName', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('phone', 'Contact Phone', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('phone', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
    <div class="form-group row {{ $errors->has('email') ? 'alert-danger' : '' }}">
        {!! Form::label('email', 'Contact Email', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('email', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Other information:</legend>

    @php ($urls = ['url'=>'Web Page','imageUrl'=>'Image', 'flyerUrl'=>'Flyer', 'facebookUrl'=>'Facebook Event', 'ticketUrl'=>'Tickets', 'altMapUrl'=>'Alternate Map'])

    @foreach($urls as $key => $value)
        <div class="form-group row {{ $errors->has($key) ? 'alert-danger' : '' }}">
            {!! Form::label($key, $value, ['class'=>'form-control-label col-sm-2']) !!}
            {!! Form::text($key, null, ['placeholder'=>'http://','class'=>'form-control col-sm-6']) !!}
        </div>
    @endforeach

</fieldset>

<div class="form-group row">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary form-control offset-sm-2 col-sm-10']) !!}
</div>