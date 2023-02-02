<?php
$crops = App\Models\Crop::pluck('name','id');
$farmers = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');

?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 100]) !!}
</div>

<!-- Size Field -->
<div class="form-group col-sm-6">
    {!! Form::label('size', 'Size:') !!}
    {!! Form::number('size', null, ['class' => 'form-control','min'=>1]) !!}
</div>

<!--Field Size Unit-->
<div class="form-group col-sm-6">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    {!! Form::text('size_unit', null, ['class' => 'form-control','placeholder'=>'Acres','readonly']) !!}
</div>

<!-- Crop Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crop_id', 'Crop:') !!}
    {!! Form::select('crop_id', $crops, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Owner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner', 'Farmer:') !!}
    {!! Form::select('owner', $farmers, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- farm id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('farm_id', 'Farm:') !!}
    <select id="farm" name="farm_id" class="form-control">

    </select>
</div>




@push('scripts')

    <script>

        $(document).ready(function() {

            $('#owner').on('change', function() {
                var idFarmer = this.value;

                $('#farm').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('farmers.fetch-farms') }}",
                    type: "get",
                    data: {
                        owner: idFarmer
                    },
                    dataType: 'json',
                    success: function(result) {

                        console.log(result)

                        $('#farm').html('<option value="">-- Select a farm --</option>');

                        $.each(result.farms, function(key, value) {

                            $("#farm").append('<option value="' + value
                                .id + '">' + value.name  + '</option>');


                        });

                    }
                });
            });



        })
    </script>
@endpush

