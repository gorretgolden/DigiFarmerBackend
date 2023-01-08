
<?php
$countries = App\Models\Country::pluck('name','id');
$users = App\Models\User::where('user_type','farmer')->pluck('username','id');
?>

<!-- Country Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country_id', 'Country:') !!}
    {!! Form::select('country_id', $countries, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- District Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district_name', 'District Name:') !!}
    {!! Form::text('district_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_name', 'Address Name:') !!}
    {!! Form::text('address_name', null, ['class' => 'form-control']) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>

