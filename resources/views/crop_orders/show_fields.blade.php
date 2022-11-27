<!-- Is Paid Field -->
<div class="col-sm-12">
    {!! Form::label('is_paid', 'Paid Order:') !!}
    @if ($cropOrder->is_paid == 0)
        <span class="badge rounded-pill bg-warning">Not paid</span>
    @else
        <span class="badge rounded-pill bg-success">Paid</span>
    @endif
</div>

<!-- Is Accepted Field -->
<div class="col-sm-12">
    {!! Form::label('is_accepted', 'Accepted by farmer:') !!}
    @if ($cropOrder->is_accepted == 0)
    <span class="badge rounded-pill bg-info">Price not accepted</span>
    @else
    <span class="badge rounded-pill bg-success">Price accepted</span>

    @endif
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'Crop  Buyer:') !!}
    <p>Username: {{ $cropOrder->user->username }} Email: {{ $cropOrder->user->email }} Contact:
        {{ $cropOrder->user->phone }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cropOrder->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cropOrder->updated_at }}</p>
</div>
