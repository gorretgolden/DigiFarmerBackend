<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!--type-->

<div class="form-group col-sm-6">
    {!! Form::label('type') !!}
    {!! Form::select('type', ['Home' => 'Home', 'Farm' => 'Farm','Market'=>'Market'],null, ['class' => 'form-control','placeholder'=>'Select type'] ) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enabled', 'Enabled:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>
<div class="clearfix"></div>
