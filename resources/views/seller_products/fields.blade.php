
<?php
$seller_product_categories = App\Models\SellerProductCategory::pluck('name','id');
$users = App\Models\User::where('user_type','farmer')->pluck('username','id');

?>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 100]) !!}
</div>

<!-- Seller Product Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('seller_product_category_id', 'Category:') !!}
    {!! Form::select('seller_product_category_id', $seller_product_categories , null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control','min'=>1]) !!}
</div>


<!-- Stock Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock_amount', 'Stock amount:') !!}
    {!! Form::number('stock_amount', null, ['class' => 'form-control','min'=>1]) !!}
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

<!-- User-->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Sellers:') !!}
    {!! Form::select('user_id', $users , null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">

    </select>
</div>


<!-- Is verified Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_verified', 'Verify:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_verified', 0) !!}
        {!! Form::checkbox('is_verified', '1', null) !!}
    </label>
</div>


{{-- <!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div> --}}



@push('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        console.log('hfgkkk');
        $(document).ready(function() {

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

                        $('#farmer-address').html('<option value="">-- Select farmer address --</option>');

                        $.each(result.addresses, function(key, value) {
                            console.log(result)

                            $("#farmer-address").append('<option value="' + value
                                .id + '">' + value.address_name + " " + value.district_name + '</option>');

                                console.log('hello',value.district_name)

                        });

                    }
                });
            });
        })
    </script>
@endpush
