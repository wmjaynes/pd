<fieldset class='form-group'>
    <legend>Organization:</legend>
    <div class="form-group row {{ $errors->has('name') ? 'alert-danger' : '' }}">
        {!! Form::label('name', 'Event Name', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('name', null, ['class'=>'form-control col-sm-6']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Address:</legend>
    <div class="form-group row">
        {!! Form::label('address1', 'Address 1', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('address1', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('address1', 'Address 2', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('address1', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('city', 'City', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('city', null, ['class'=>'form-control col-sm-3']) !!}
        {!! Form::label('state', 'State', ['class'=>'form-control-label col-sm-1']) !!}
        {!! Form::text('state', null, ['class'=>'form-control col-sm-1']) !!}
        {!! Form::label('postalCode', 'Zip', ['class'=>'form-control-label col-sm-1']) !!}
        {!! Form::text('postalCode', null, ['class'=>'form-control col-sm-1']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Contact:</legend>

    <div class="form-group row">
        {!! Form::label('contactName', 'Contact Name', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('contactName', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('email', 'Org Email', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('email', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('phone', 'Org Phone', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('phone', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
</fieldset>

<fieldset class='form-group'>
    <legend>Misc:</legend>
    <div class="form-group row">
        {!! Form::label('description', 'Description', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::textarea('description', null, ['class'=>'form-control col-sm-8']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('url', 'Web Address', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('url', null, ['class'=>'form-control col-sm-8','placeholder'=>'http://']) !!}
    </div>
    <div class="form-group row">
        {!! Form::label('logoUrl', 'Address of Logo image', ['class'=>'form-control-label col-sm-2']) !!}
        {!! Form::text('logoUrl', null, ['class'=>'form-control col-sm-8','placeholder'=>'http://']) !!}
    </div>
</fieldset>

<div class="form-group row">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary form-control offset-sm-2 col-sm-10']) !!}
</div>