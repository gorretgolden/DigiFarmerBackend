<?php
$farmers = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 20, 'placeholder' => 'Enter farm name']) !!}
</div>

<!-- Owner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner', 'Farmer:') !!}
    {!! Form::select('owner', $farmers, null, ['class' => 'form-control custom-select']) !!}
</div>




<!-- Field Area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('field_area', 'Field Area:') !!}
    {!! Form::number('field_area', null, ['class' => 'form-control', 'placeholder' => 'Enter farm field area','min'=>1]) !!}
</div>

<!--Field Size Unit-->
<div class="form-group col-sm-6">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    {!! Form::text('size_unit', null, ['class' => 'form-control','placeholder'=>'Acres','readonly']) !!}
</div>

<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">

    </select>
</div>




@push('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
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
@endpush
