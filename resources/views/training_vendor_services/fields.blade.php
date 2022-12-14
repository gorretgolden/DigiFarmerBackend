
<?php
$users = App\Models\User::where('user_type',"farmer")->pluck('username','id');
$vendor_categories = App\Models\VendorCategory::pluck('name','id');
$period_units = App\Models\PeriodUnit::pluck('name','id');
?>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge', 'Charge:') !!}
    {!! Form::number('charge', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>



<!-- Period  Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period', 'Period:') !!}
    {!! Form::text('period', null, ['class' => 'form-control','placeholder'=>'1']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('Access') !!}
    {!! Form::select('access', ['Online'=>'Online','Offline'=>'Offline'],null, ['class' => 'form-control select select-access'] ) !!}
</div>




<!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Period Unit Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_unit_id', 'Period Unit:') !!}
    {!! Form::select('period_unit_id', $period_units, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Starting Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_date', 'Starting Date:') !!}
    {!! Form::text('starting_date', null, ['class' => 'form-control','id'=>'starting_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#starting_date').datetimepicker({
            format: 'DD-MM-YYYY',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush


<!-- Starting Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_time', 'Starting Time:') !!}
    {!! Form::text('starting_time', null, ['class' => 'form-control','id'=>'starting_time']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#starting_time').datetimepicker({
            format: 'HH:mm',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Ending Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ending_date', 'Ending Date:') !!}
    {!! Form::text('ending_date', null, ['class' => 'form-control','id'=>'ending_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#ending_date').datetimepicker({
            format: 'DD-MM-YYYY ',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush


<!-- Ending Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ending_time', 'Ending Time:') !!}
    {!! Form::text('ending_time', null, ['class' => 'form-control','id'=>'ending_time']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#ending_time').datetimepicker({
            format: 'HH:mm ',
            useCurrent: true,
            sideBySide: true
        })
    </script>
<!-- Zoom Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    {!! Form::textarea('zoom_details', null, ['class' => 'form-control find']) !!}
</div>

<!-- Location Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('location_details', 'Location Details:') !!}
    {!! Form::textarea('location_details', null, ['class' => 'form-control rep']) !!}
</div>

<script>
    $(document).ready(function(){
        $("select-access").change(function(){
            $( "select option:selected").each(function(){
                if($(this).attr("access")=="Online"){
                    $(".rep").hide();
                    $(".find").show();
                    $(".replace").show();
                } else {
                    $(".rep").show();
                    $(".find").hide();
                    $(".replace").hide();
                }
            });
        }).change();
    });
</script>
@endpush




<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendor :') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Zoom Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    {!! Form::textarea('zoom_details', null, ['class' => 'form-control find']) !!}
</div>

<!-- Location Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('location_details', 'Location Details:') !!}
    {!! Form::textarea('location_details', null, ['class' => 'form-control rep']) !!}
</div>
