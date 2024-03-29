<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $country->name }}</p>
</div>

<!-- Short Code Field -->
<div class="col-sm-12">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $country->short_code }}</p>
</div>

<!-- Country Code Field -->
<div class="col-sm-12">
    {!! Form::label('country_code', 'Country Code:') !!}
    <p>{{ $country->country_code }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $country->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $country->updated_at }}</p>
</div>

