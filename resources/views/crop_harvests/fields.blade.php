<?php
$plots = App\Models\Plot::all();
$farmers = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');
?>


<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    {!! Form::text('quantity_unit', null, ['class' => 'form-control']) !!}
</div>



{{--
<select class="custom-select" name="plot_id" >
    <option value="" selected disabled hidden>Select Plot for harvest</option>
    @foreach ($plots as $plot)
        <option value="{{ $plot->id }}">
            {{ $plot->name}}  on {{ $plot->farm->name}} by Farmer: {{ $plot->farm->address->user->username}}
        </option>
    @endforeach

</select> --}}


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

<!-- farm plots Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plot_id', 'Plot:') !!}
    <select id="plot" name="plot_id" class="form-control">

    </select>
</div>


@push('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        console.log('hfgkkk');
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


            $('#farm').on('change', function() {
                var idFarm = this.value;
                console.log(idFarm)

                $('#plot').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('farmers.fetch-farm-plots') }}",
                    type: "get",
                    data: {
                        farm_id: idFarm
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#plot').html('<option value="">-- Select a plot --</option>');

                        $.each(result.plots, function(key, value) {

                            $("#plot").append('<option value="' + value
                                .id + '">' + value.name  + '</option>');


                        });

                    }
                });
            });
        })
    </script>
@endpush
