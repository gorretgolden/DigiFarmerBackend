<!-- Commission Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commission', 'Commission:') !!}
    {!! Form::number('commission', App\Models\GeneralSettings::getCommission(), ['class' => 'form-control']) !!}
</div>

<!-- Commission Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commission_unit', 'Commission Unit:') !!}
    {!! Form::text('commission_unit', App\Models\GeneralSettings::getCommissionUnit(), ['class' => 'form-control']) !!}
</div>

<!-- App Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('app_name', 'App Name:') !!}
    {!! Form::text('app_name', App\Models\GeneralSettings::getAppName(), ['class' => 'form-control']) !!}
</div>

<!-- Currency Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('currency_unit', 'Currency Unit:') !!}
    {!! Form::text('currency_unit', App\Models\GeneralSettings::getCurrencyUnit(), ['class' => 'form-control']) !!}
</div>



