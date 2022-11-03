<!-- Farm Id Field -->
<div class="col-sm-12">
    {!! Form::label('farm_id', 'Farm Id:') !!}
    <p>{{ $harvest->farm_id }}</p>
</div>

<!-- Harvest Amount Field -->
<div class="col-sm-12">
    {!! Form::label('harvest_amount', 'Harvest Amount:') !!}
    <p>{{ $harvest->harvest_amount }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $harvest->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $harvest->updated_at }}</p>
</div>

