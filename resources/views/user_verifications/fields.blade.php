<?php
$users = App\Models\User::where('is_verified',false)->pluck('username','id');
?>

<!-- verified Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('verified', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('verified', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('verified', 'Verify', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Image Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image[]', ['class' => 'custom-file-input','multiple']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div> --}}


<div class="form-group col-sm-6">

    <label>Choose Images for Verification</label>
    <input class="custom-file-label" type="file" name="image[]" multiple>
</div>

<div class="clearfix"></div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Users:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>
