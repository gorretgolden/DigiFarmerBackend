<!-- First Name Field -->
<div class="col-sm-12">
    {!! Form::label('first_name', 'First Name:') !!}
    <p>{{ $seller->first_name }}</p>
</div>

<!-- Last Name Field -->
<div class="col-sm-12">
    {!! Form::label('last_name', 'Last Name:') !!}
    <p>{{ $seller->last_name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $seller->email }}</p>
</div>

<!-- Image Url Field -->
<div class="col-sm-12">
    {!! Form::label('image_url', 'Image Url:') !!}
    <p>{{ $seller->image_url }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $seller->phone }}</p>
</div>

<!-- User Type Field -->
<div class="col-sm-12">
    {!! Form::label('user_type', 'User Type:') !!}
    <p>{{ $seller->user_type }}</p>
</div>

<!-- Country Id Field -->
<div class="col-sm-12">
    {!! Form::label('country_id', 'Country:') !!}
    <p>{{ $seller->country->name }}</p>
</div>

<!-- Password Field -->
<div class="col-sm-12">
    {!! Form::label('password', 'Password:') !!}
    <p>{{ $seller->password }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $seller->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $seller->updated_at }}</p>
</div>

