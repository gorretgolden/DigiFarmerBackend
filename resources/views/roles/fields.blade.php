<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>



<div class="col-md-8">
    <strong>Permission:</strong>
    <br/>

    @foreach ($permissions as  $key => $value )
  <div class="display:grid;grid-template-columns:repeat(2,1fr)">
    <label class="label label-success">
        {!! Form::checkbox('permission[]', $value, false, ['class', 'permission']) !!}
        {{ $value }}
    </label>

  </div>
    @endforeach


</div>
