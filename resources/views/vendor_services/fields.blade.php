<?php
$categories = App\Models\Category::where('is_active', 1)
    ->where('type', 'vendors')
    ->pluck('name', 'id');
$crops = App\Models\Crop::where('is_active', 1)
    ->pluck('name', 'id');
$live_stock = App\Models\AnimalCategory::where('is_active', 1)
    ->where('type', 'livestock')
    ->pluck('name', 'id');
$poultry = App\Models\AnimalCategory::where('is_active', 1)
    ->where('type', 'poultry')
    ->pluck('name', 'id');
$users = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');
$loan_plans = \DB::table('loan_plans')
    ->select(\DB::raw("CONCAT(value, ' ', period_unit) AS duration"), 'id')
    ->orderBy('value', 'ASC')
    ->pluck('duration', 'id');
?>




<!--required fields-->


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>




<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', $categories, null, [
        'class' => 'form-control custom-select',
        'placeholder' => 'Select category',
    ]) !!}
</div>

<!-- Sub Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sub_category_id', 'Sub Category:') !!}
    <select id="sub_category_id" name="sub_category_id" class="form-control">


    </select>

</div>



<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Users:') !!}
    {!! Form::select('user_id', $users, null, [
        'class' => 'form-control custom-select',
        'placeholder' => 'Select farmer',
    ]) !!}
</div>
<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">


    </select>
</div>


<!-- Price Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    {!! Form::text('price_unit', null, ['class' => 'form-control', 'placeholder' => 'UGX', 'readonly']) !!}
</div>





<!-- Is Verified Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_verified', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_verified', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_verified', 'Is Verified', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'minlength' => 20, 'maxlength' => 255]) !!}
</div>


<!--optional fields-->


<!-- Crops Field -->
<div class="form-group col-sm-6" id="crop-container">
    {!! Form::label('crops', 'Category:') !!}
    {!! Form::select('crops[]', $crops, null, [
        'class' => 'form-control custom-select',
        'placeholder' => 'Select crop',
        'multiple'
    ]) !!}
</div>


<!-- Price  Field -->
<div class="form-group col-sm-6" id="price-container">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control', 'min' => 1000]) !!}
</div>


<!-- Stock Amount Field -->
<div class="form-group col-sm-6" id="stock-container">
    {!! Form::label('stock_amount', 'Stock Amount:') !!}
    {!! Form::number('stock_amount', null, ['class' => 'form-control', 'min' => 1]) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6" id="status-container">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['available-for-rent'=>'Available for rent','on-sale' => 'On-sale', 'sold' => 'Sold', 'open' => 'Open'], null, [
        'class' => 'form-control custom-select',
    ]) !!}
</div>

<!--animal feeds-->

<!--live st0ck-->

<div class="form-group col-sm-6" id="livestock">
    {!! Form::label('animal_categories', 'Livestock:') !!}
    {!! Form::select('animal_categories[]', $live_stock, null, [
        'class' => 'form-control custom-select',
        'placeholder' => 'Select category',
        'multiple',
    ]) !!}
</div>

<!--poultry-->
<div class="form-group col-sm-6" id="poultry">
    {!! Form::label('animal_categories', 'Poultry:') !!}
    {!! Form::select('animal_categories[]', $poultry, null, [
        'class' => 'form-control custom-select',
        'placeholder' => 'Select category',
        'multiple',
    ]) !!}
</div>


<!-- Weight Field -->

<div class="form-group col-sm-6" id="weight-container">
    {!! Form::label('weight', 'Weight:') !!}
    {!! Form::number('weight', null, ['class' => 'form-control', 'minlength' => 1, 'maxlength' => 255]) !!}
</div>


<!-- Weight Unit Field -->

<div class="form-group col-sm-6" id="weight-unit-container">
    {!! Form::label('weight_unit', 'Weight Unit:') !!}
    {!! Form::select('weight_unit', ['kg' => 'kg', ' ml' => ' ml', 'g' => 'g', 'l' => 'l'], null, [
        'class' => 'form-control',
    ]) !!}
</div>







<!--agronomist and vet-->
<!-- Expertise Field -->
<div class="form-group col-sm-12 col-lg-12" id="expertise-container">
    {!! Form::label('expertise', 'Expertise:') !!}
    {!! Form::textarea('expertise', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>




<!--rent vendors-->

<!-- Charge  Frequency-->
<div class="form-group col-sm-6" id="charge-container">
    {!! Form::label('charge', 'Charge :') !!}
    {!! Form::number(
        'charge',

        null,
        ['class' => 'form-control', 'min' => 1000],
    ) !!}
</div>

<!-- Charge Day Frequency-->
<div class="form-group col-sm-6" id="charge-frequency-container">
    {!! Form::label('charge_frequency', 'Charge Frequency:') !!}
    {!! Form::select(
        'charge_frequency',
        ['per day' => 'per day', 'per hour' => 'per hour', 'per piece' => 'per piece'],
        null,
        ['class' => 'form-control'],
    ) !!}
</div>





<!--training vendors , veterinary and agronomist-->
<!-- Zoom Details Field -->
<div class="form-group col-sm-12 col-lg-12" id="zoom-details-container">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    {!! Form::textarea('zoom_details', null, ['class' => 'form-control']) !!}
</div>




<!--training vendors-->
<!-- Starting Date Field -->
<div class="form-group col-sm-6" id="starting-date-container">
    {!! Form::label('starting_date', 'Starting Date:') !!}
    {!! Form::text('starting_date', null, ['class' => 'form-control', 'id' => 'starting_date']) !!}
</div>


<!-- Ending Date Field -->
<div class="form-group col-sm-6" id="ending-date-container">
    {!! Form::label('ending_date', 'Ending Date:') !!}
    {!! Form::text('ending_date', null, ['class' => 'form-control', 'id' => 'ending_date']) !!}
</div>

<!-- Starting Date Field -->
<div class="form-group col-sm-6" id="starting-time-container">
    {!! Form::label('starting_time', 'Starting Time:') !!}
    {!! Form::text('starting_time', null, ['class' => 'form-control', 'id' => 'starting_time']) !!}
</div>


<!-- Ending Date Field -->
<div class="form-group col-sm-6" id="ending-time-container">
    {!! Form::label('ending_time', 'Ending Time:') !!}
    {!! Form::text('ending_time', null, ['class' => 'form-control', 'id' => 'ending_time']) !!}
</div>


<!--finance-->
<!-- Principal Field -->

<div class="form-group col-sm-6" id="principal-container">
    {!! Form::label('principal', 'Principal:') !!}
    {!! Form::number('principal', null, ['class' => 'form-control', 'min' => 1000]) !!}
</div>


<!-- Interest Rate Field -->
<div class="form-group col-sm-6" id="interest-rate-container">
    {!! Form::label('interest_rate', 'Interest Rate:') !!}
    {!! Form::number('interest_rate', null, ['class' => 'form-control', 'min' => 1, 'max' => 20]) !!}
</div>


<!-- Interest Rate Unit Field -->
<div class="form-group col-sm-6" id="interest-rate-unit-container">
    {!! Form::label('interest_rate_unit', 'Interest Rate Unit:') !!}
    {!! Form::text('interest_rate_unit', null, ['class' => 'form-control', 'placeholder' => '%', 'readonly']) !!}
</div>



<!-- Payment Frequency Pay Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('payment_frequency_pay', 'Payment Frequency Pay:') !!}
    {!! Form::number('payment_frequency_pay', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Simple Interest Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('simple_interest', 'Simple Interest:') !!}
    {!! Form::number('simple_interest', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Loan Plan Id Field -->

<div class="form-group col-sm-6" id="loan-plan-container">
    {!! Form::label('loan_pan_id', 'Loan Plan:') !!}
    {!! Form::select('loan_plan_id', $loan_plans, null, [
        'class' => 'form-control custom-select',
    ]) !!}
</div>


<!-- Loan Payback Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('loan_pay_back', 'Loan Payback Period:') !!}
    {!! Form::select('loan_pay_back', ['Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly'], null, [
        'class' => 'form-control',
    ]) !!} --}}

<!-- Total Amount Paid Back Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('total_amount_paid_back', 'Total Amount Paid Back:') !!}
    {!! Form::number('total_amount_paid_back', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Document Type Field -->
<div class="form-group col-sm-6" id="document-type-container">
    {!! Form::label('document_type', 'Document Type :') !!}
    {!! Form::select(
        'document_type',
        ['National Id' => 'National Id', 'Driving Permit' => 'Driving Permit', 'Land Title' => 'Land Title'],
        null,
        [
            'class' => 'form-control',
        ],
    ) !!}
</div>




<!-- Terms Field -->
<div class="form-group col-sm-12 col-lg-12" id="terms-container">
    {!! Form::label('terms', 'Terms:') !!}
    {!! Form::textarea('terms', null, [
        'class' => 'form-control',
        'placeholder' => 'Terms for the loan',
        'minlength' => 10,
    ]) !!}
</div>


</div>



<!--agronomst, training and vet-->
<div class="form-group col-sm-6" id="access-container">
    {!! Form::label('Access') !!}
    {!! Form::select(
        'access',
        ['online' => 'Online', 'offline' => 'Offline', 'call' => 'Call', 'in-person' => 'In-person'],
        null,
        ['class' => 'form-control type', 'placeholder' => 'Select access type'],
    ) !!}
</div>



@push('scripts')
    <script>
        console.log('hfgkkgy778889k');
        $(document).ready(function() {

            //user address
            $('#user_id').on('change', function() {
                var idFarmer = this.value;


                $('#farmer-address').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('sellers.fetch-address') }}",
                    type: "get",
                    data: {
                        user_id: idFarmer
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#farmer-address').html(
                            '<option value="">-- Select farmer address --</option>');

                        $.each(result.addresses, function(key, value) {


                            $("#farmer-address").append('<option value="' + value
                                .id + '">' + value
                                .district_name + '</option>');


                        });




                    }
                });



            });


            //category
            $('#category_id').on('change', function() {
                var idCategory = this.value;


                $('#sub_category_id').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('categories.sub_categories') }}",
                    type: "get",
                    data: {
                        category_id: idCategory
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#sub_category_id').html(
                            '<option value="">-- Select sub category --</option>');

                        $.each(result.sub_categories, function(key, value) {


                            $("#sub_category_id").append('<option value="' + value
                                .id + '">' + value
                                .name + '</option>');


                        });




                    }
                });



            });

            $('#ending_time').datetimepicker({
                format: 'hh:mm A',
                useCurrent: true,
                sideBySide: true
            })

            $('#ending_date').datetimepicker({
                format: 'DD-MM-YYYY ',
                useCurrent: true,
                sideBySide: true
            })

            $('#starting_time').datetimepicker({
                format: 'hh:mm A',
                useCurrent: true,
                sideBySide: true
            })

            $('#starting_date').datetimepicker({
                format: 'DD-MM-YYYY',
                useCurrent: true,
                sideBySide: true
            })

            $('#ending_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                sideBySide: true
            })
            $('#starting_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                sideBySide: true
            })

        })

        //hide optional fields
        $('#zoom-details-container').hide()
        $('#crop-container').hide()
        $('#price-container').hide()
        $('#stock-container').hide()
        $('#status-container').hide()
        $('#expertise-container').hide()
        $('#terms-container').hide()
        $('#weight-container').hide()
        $('#weight-unit-container').hide()
        $('#charge-container').hide()
        $('#charge-frequency-container').hide()
        $('#starting-date-container').hide()
        $('#ending-date-container').hide()
        $('#starting-time-container').hide()
        $('#ending-time-container').hide()
        $('#principal-container').hide()
        $('#interest-rate-container').hide()
        $('#interest-rate-unit-container').hide()
        $('#document-type-container').hide()
        $('#loan-plan-container').hide()
        $('#access-container').hide()
        $('#livestock').hide()
        $('#poultry').hide()

        $('#category_id').on('change', function() {
            var category = $(this).find("option:selected").text()

            if (category == 'Animal Feeds') {
                $('#price-container').show()
                $('#stock-container').show()
                $('#status-container').show()
                $('#weight-container').show()
                $('#weight-unit-container').show()
                $('#starting-date-container').hide()
                $('#ending-date-container').hide()
                $('#starting-time-container').hide()
                $('#ending-time-container').hide()

            } else if (category == 'Farmer Trainings') {
                $('#starting-date-container').show()
                $('#ending-date-container').show()
                $('#starting-time-container').show()
                $('#ending-time-container').show()
                $('#status-container').hide()
                $('#weight-container').hide()
                $('#weight-unit-container').hide()
                $('#stock-container').hide()
                $('#crop-container').hide()

            } else if (category == 'Rent') {

                $('#charge-container').show()
                $('#charge-frequency-container').show()
                $('#stock-container').show()
                $('#status-container').show()
                $('#starting-date-container').hide()
                $('#ending-date-container').hide()
                $('#starting-time-container').hide()
                $('#ending-time-container').hide()
                $('#weight-container').hide()
                $('#weight-unit-container').hide()
                $('#price-container').hide()
                $('#crop-container').hide()


            } else if (category == 'Finance') {
                $('#principal-container').show()
                $('#interest-rate-container').show()
                $('#interest-rate-unit-container').show()
                $('#document-type-container').show()
                $('#loan-plan-container').show()
                $('#charge-container').hide()
                $('#charge-frequency-container').hide()
                $('#stock-container').hide()
                $('#status-container').hide()
                $('#starting-date-container').hide()
                $('#ending-date-container').hide()
                $('#starting-time-container').hide()
                $('#ending-time-container').hide()
                $('#weight-container').hide()
                $('#weight-unit-container').hide()
                $('#price-container').hide()
                $('#crop-container').hide()


            } else if (category == 'Agronomists') {
                $('#principal-container').hide()
                $('#interest-rate-container').hide()
                $('#interest-rate-unit-container').hide()
                $('#document-type-container').hide()
                $('#loan-plan-container').hide()
                $('#charge-frequency-container').hide()
                $('#stock-container').hide()
                $('#status-container').hide()
                $('#starting-date-container').hide()
                $('#ending-date-container').hide()
                $('#starting-time-container').hide()
                $('#ending-time-container').hide()
                $('#weight-container').hide()
                $('#weight-unit-container').hide()
                $('#price-container').hide()
                $('#crop-container').show()
                $('#charge-container').show()
                $('#expertise-container').show()


            }

            else if (category == 'Insurance') {
                $('#principal-container').hide()
                $('#interest-rate-container').hide()
                $('#interest-rate-unit-container').hide()
                $('#document-type-container').hide()
                $('#loan-plan-container').hide()
                $('#charge-frequency-container').hide()
                $('#stock-container').hide()
                $('#status-container').hide()
                $('#starting-date-container').hide()
                $('#ending-date-container').hide()
                $('#starting-time-container').hide()
                $('#ending-time-container').hide()
                $('#weight-container').hide()
                $('#weight-unit-container').hide()
                $('#price-container').hide()
                $('#charge-container').hide()
                $('#crop-container').hide()
                $('#charge-container').hide()
                $('#terms-container').show()


            }

            else if (category == 'Farm Equipments') {
                $('#principal-container').hide()
                $('#interest-rate-container').hide()
                $('#interest-rate-unit-container').hide()
                $('#document-type-container').hide()
                $('#loan-plan-container').hide()
                $('#charge-frequency-container').hide()
                $('#stock-container').show()
                $('#status-container').show()
                $('#starting-date-container').hide()
                $('#ending-date-container').hide()
                $('#starting-time-container').hide()
                $('#ending-time-container').hide()
                $('#weight-container').hide()
                $('#weight-unit-container').hide()
                $('#price-container').show()
                $('#charge-container').hide()
                $('#crop-container').hide()
                $('#charge-container').hide()
                $('#terms-container').hide()
                $('#expertise-container').hide()


            }
            else {
                $('#address-container').show()
                $("#zoom-details-container").hide();

            }


        });

        $('#sub_category_id').on('change', function() {
            var sub_category = $(this).find("option:selected").text()
            console.log(sub_category)

            if (sub_category == 'Poultry Feeds') {

                $('#livestock').hide()
                $('#poultry').show()

            } else if (sub_category == 'Livestock Feeds') {
                $('#livestock').show()
                $('#poultry').hide()

            } else {
                $('#poultry').hide()
                $('#livestock').hide()
            }


        });
    </script>
@endpush
