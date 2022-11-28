<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $farm->name }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $farm->address }}</p>
</div>

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{{ $farm->latitude }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{{ $farm->longitude }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $farm->user->username}}</p>
</div>

<!-- Field Area Field -->
<div class="col-sm-12">
    {!! Form::label('field_area', 'Field Area:') !!}
    <p>{{ $farm->field_area }}</p>
</div>

<!-- Size Unit Field -->
<div class="col-sm-12">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    <p>{{ $farm->size_unit }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $farm->image }}</p>
</div>




<!--farm plots-->
<div class="col-sm-12">
    {!! Form::label('plots', 'Total Plots:') !!}  {{ $farm->plots->count() }}
    @foreach($farm->plots as $plot)
    <p>{{$plot->name}}</p>

    @endforeach

</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $farm->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $farm->updated_at }}</p>
</div>
