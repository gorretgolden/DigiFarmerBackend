<?php
$vendors = App\Models\User::where('user_type','farmer')->pluck('username','id');
$vendor_categories = App\Models\VendorCategory::pluck('name','id');
?>



<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Terms Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('terms', 'Terms:') !!}
    {!! Form::textarea('terms', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">

    </select>
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
{{-- <!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div> --}}


@push('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>

        $(document).ready(function() {

            $('#rent_vendor_category_id').on('change', function() {
                var id_rent = this.value;

                $('#sub_category').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('rent.sub-categories')}}",
                    type: "get",
                    data: {
                        rent_vendor_category_id: id_rent
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#sub_category').html('<option value="">-- Select sub category --</option>');

                        $.each(result.Sub_categories, function(key, value) {
                            console.log(result)

                            $("#sub_category").append('<option value="' + value
                                .id + '">' + value.name  + '</option>');

                                console.log('hello',value.name)

                        });

                    }
                });
            });
        })
    </script>

      <script>
        console.log('hfgkkk');
        $(document).ready(function() {

            $('#owner').on('change', function() {
                var idFarmer = this.value;

                $('#farmer-address').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('farmers.fetch-address') }}",
                    type: "get",
                    data: {
                        owner: idFarmer
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#farmer-address').html('<option value="">-- Select farmer address --</option>');

                        $.each(result.addresses, function(key, value) {

                            $("#farmer-address").append('<option value="' + value
                                .id + '">' + value.address_name + " " + value.district_name + '</option>');

                                console.log('hello',value.district_name)

                        });

                    }
                });
            });
        })
    </script>

<script>

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

                    $('#farmer-address').html('<option value="">-- Select vendor address --</option>');

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

