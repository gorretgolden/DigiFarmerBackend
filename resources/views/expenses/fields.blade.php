<?php
$expense_categories= App\Models\ExpenseCategory::pluck('name','id');
$plots= App\Models\Plot::all();
$farmers = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');
?>
<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Expense Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('expense_category_id', 'Expense Category:') !!}
    {!! Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control custom-select']) !!}
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

