<fieldset class='form-group'>
    {!! Form::hidden('visible', 1) !!}
    <legend>Venue:</legend>
    <div class="form-group row {{ $errors->has('name') ? 'alert-danger' : '' }}">
        {!! Form::label('name', 'Venue Name', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('name', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Address:</legend>
    <div class="form-group row">
        {!! Form::label('streetAddress', 'Street', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('streetAddress', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('addressLocality', 'City', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('addressLocality', null, ['class'=>'form-control col-sm-2']) !!}
        {!! Form::label('addressRegion', 'State', ['class'=>'form-control-label col-sm-1']) !!}
        {!! Form::text('addressRegion', null, ['class'=>'form-control col-sm-1']) !!}
        {!! Form::label('postalCode', 'Postal Code', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('postalCode', null, ['class'=>'form-control col-sm-2']) !!}
    </div>
</fieldset>


<div class="form-group row">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary form-control offset-sm-2 col-sm-10']) !!}
</div>