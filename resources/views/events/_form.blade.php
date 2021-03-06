<div class="form-group row">
    {!! Form::submit($submitButtonText, ['name'=>'submit', 'class'=>'btn btn-primary form-control col-sm-5']) !!}
    &nbsp;
    {!! Form::submit("Save and return to events listing", ['name'=>'submit', 'class'=>'btn btn-primary form-control col-sm-5']) !!}
</div>

<fieldset class='form-group'>
    <legend>Approval:</legend>
    <div>When you first create an event it is "unpublished" (hidden from the public).
        When you wish to release it, check "Publish" below.
    </div>

    <div class="form-check form-check-inline">
        <label class="form-check-label">Approval</label>

        <div class="form-check form-check-inline">
            {!! Form::label('published', 'Publish', ['class'=>'form-check-label']) !!}
            {!! Form::radio('published', 1, ['class'=>'form-check-input']) !!}
        </div>
        <div class="form-check form-check-inline">
            {!! Form::label('published', 'Unpublish', ['class'=>'form-check-label']) !!}
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

    <div class="form-group row bootstrap-timepicker timepicker {{ $errors->has('startDate') ? 'alert-danger' : '' }}">
        {!! Form::label('xstartDate', 'Start Date', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('xstartDate', null, ['class'=>'form-control col-sm-3','placeholder'=>'e.g. 2/1/2017']) !!}
        {!! Form::label('startTime', 'Start Time', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('startTime', null, ['class'=>'form-control col-sm-2 input-small']) !!}
    </div>

    <div class="form-group row {{ $errors->has('endDate') ? 'alert-danger' : '' }}">
        {!! Form::label('xendDate', 'End Date', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('xendDate', null, ['class'=>'form-control col-sm-3']) !!}
        {!! Form::label('endTime', 'End Time', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('endTime', null, ['class'=>'form-control col-sm-2 input-small']) !!}
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
    <legend>Venue:</legend>
    <div class="form-group row">
        {!! Form::label('venue', 'Venues', ['class'=>'form-control-label col-sm-3']) !!}
        {!! Form::select('venue', ['Previous Venues'=> $venueDropdown->toArray(), 'All Other Venues'=>$allVenuesDropdown->toArray()],  $currentVenueId, ['class'=>'form-control col-sm-6', 'placeholder'=>"Previous Venues..."]) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('venueDetail', 'Venue Detail', ['class'=>'form-control-label col-sm-3']) !!}
        {!! Form::textarea('venueDetail', null, ['size'=>'50x2', 'class'=>'form-control col-sm-6', "placeholder"=>"e.g. 'Room C45' or 'Parking Lot F' or 'Please don't park in a numbered space.' "]) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Admission (tickets, registration, admission info):</legend>
    <div class="form-group row">
        {!! Form::label('ticketInfo', ' ', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::textarea('ticketInfo', null, ['size'=>'50x2', 'class'=>'form-control col-sm-6']) !!}
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

    @php ($urls = ['url'=>'Web Page','imageUrl'=>'Logo Image', 'flyerUrl'=>'Flyer', 'facebookUrl'=>'Facebook Event', 'ticketUrl'=>'Tickets', 'altMapUrl'=>'Alternate Map'])

    @foreach($urls as $key => $value)
        <div class="form-group row {{ $errors->has($key) ? 'alert-danger' : '' }}">
            {!! Form::label($key, $value, ['class'=>'form-control-label col-sm-2']) !!}
            {!! Form::text($key, null, ['placeholder'=>'https://','class'=>'form-control col-sm-6']) !!}
        </div>
    @endforeach

</fieldset>

<div class="form-group row">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary form-control col-sm-5']) !!}
    &nbsp;
    {!! Form::submit("Save and return to events listing", ['name'=>'submit', 'class'=>'btn btn-primary form-control col-sm-5']) !!}
</div>

<script>
    $('#xstartDate').datepicker({
        autoclose: true
    });
    $('#xendDate').datepicker({
        autoclose: true
    });
    $("#startTime, #endTime").timepicker({
        minuteStep: 15,
        showInputs: true,
        disableFocus: true,
        defaultTime: false,
    });
    $().ready(function () {

        $('#xstartDate').change(function () {
            dt = $(this).val();
            $('#xendDate').val(dt);
        });
    });

</script>
