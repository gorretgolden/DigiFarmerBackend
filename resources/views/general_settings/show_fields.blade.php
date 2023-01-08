<!-- Commission Field -->
<div class="col-sm-12">
    {!! Form::label('commission', 'Commission:') !!}
    <p>{{ $generalSetting->commission }}</p>
</div>

<!-- Commission Unit Field -->
<div class="col-sm-12">
    {!! Form::label('commission_unit', 'Commission Unit:') !!}
    <p>{{ $generalSetting->commission_unit }}</p>
</div>

<!-- App Name Field -->
<div class="col-sm-12">
    {!! Form::label('app_name', 'App Name:') !!}
    <p>{{ $generalSetting->app_name }}</p>
</div>

<!-- Currency Unit Field -->
<div class="col-sm-12">
    {!! Form::label('currency_unit', 'Currency Unit:') !!}
    <p>{{ $generalSetting->currency_unit }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $generalSetting->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $generalSetting->updated_at }}</p>
</div>

