<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $commission->amount }}</p>
</div>

<!-- Unit Field -->
<div class="col-sm-12">
    {!! Form::label('unit', 'Unit:') !!}
    <p>{{ $commission->unit }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $commission->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $commission->updated_at }}</p>
</div>

