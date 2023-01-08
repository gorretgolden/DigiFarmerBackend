<!-- Country Id Field -->
<div class="col-sm-12">
    {!! Form::label('country_id', 'Country Id:') !!}
    <p>{{ $address->country_id }}</p>
</div>

<!-- District Name Field -->
<div class="col-sm-12">
    {!! Form::label('district_name', 'District Name:') !!}
    <p>{{ $address->district_name }}</p>
</div>

<!-- Address Name Field -->
<div class="col-sm-12">
    {!! Form::label('address_name', 'Address Name:') !!}
    <p>{{ $address->address_name }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $address->user_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $address->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $address->updated_at }}</p>
</div>

