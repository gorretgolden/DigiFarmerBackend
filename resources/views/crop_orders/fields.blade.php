
<?php
$buyers = App\Models\User::where('user_type','farmer')->pluck('username','id');
$crops_on_sale = App\Models\CropOnSale::where('is_sold',false)->pluck('name','id');
?>

{{-- <!-- Is Paid Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_paid', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_paid', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_paid', 'Is Paid', ['class' => 'form-check-label']) !!}
    </div>
</div> --}}


{{-- <!-- Is Accepted Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_accepted', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_accepted', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_accepted', 'Is Accepted', ['class' => 'form-check-label']) !!}
    </div>
</div> --}}



<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Farmers:') !!}
    {!! Form::select('user_id', $buyers, null, ['class' => 'form-control custom-select']) !!}
</div>





<!--crops on sale-->
<div class="form-group col-sm-6">
    {!! Form::label('crop_on_sale_id', 'Crop On Sale') !!}
    <select id="crop_on_sale" name="crop_on_sale_id" class="form-control">

    </select>
</div>



<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Buyers:') !!}
    {!! Form::select('user_id', $buyers, null, ['class' => 'form-control custom-select']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('buying_price', 'Buying Price:') !!}
    {!! Form::number('buying_price', null, ['class' => 'form-control','placeholder'=>"Enter crop buying price"]) !!}
</div>
{{--
{{-- <div class="card">
    <div class="card-header">
        Crops On Sale
    </div>

    {{-- <div class="card-body">
        <table class="table" id="products_table">
            <thead>
                <tr>
                    <th>Crop</th>
                    <th>Buying Price</th>
                </tr>
            </thead>
            <tbody>
                <tr id="product0">
                    <td>
                        <select name="crops_on_sales[]" class="form-control">
                            <option value="">--Select a crop on sale--</option>
                            @foreach ($crops_on_sales  as $crop)
                                <option value="{{ $crop->id }}">
                                    {{ $crop->crop->name}} sold by  Farmer: {{$crop->user->username}} at (UGX{{ number_format($crop->selling_price, 0) }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" min="1" name="buying_prices[]" class="form-control" value="1" />
                    </td>
                </tr>
                <tr id="product1"></tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
            </div>
        </div>
    </div> --}}
{{-- </div> --}}



<script>

$(document).ready(function(){
    let row_number = 1;
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
      $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#product" + (row_number - 1)).html('');
        row_number--;
      }
    });
  });
</script>


@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {

            $('#user_id').on('change', function() {
                var idFarmer = this.value;
                console.log(idFarmer)

                $('#crop_on_sale').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('farmer.crops-on-sale') }}",
                    type: "get",
                    data: {
                        user_id: idFarmer
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#crop_on_sale').html(
                            '<option value="">-- Select crop on sale --</option>');

                        $.each(result.crops, function(key, value) {
                            console.log(result)



                            $("#crop_on_sale").append('<option value="' + value
                                .id + '">' + value.quantity +value.quantity_unit +  " " +  " of " +  value.name +  " " +  "sold at " + value
                                .selling_price +  " " + "by" +  " " + value.user.username + '</option>');


                        });

                    }
                });
            });


            $('.animal_category_id').on('change', function() {
                var category_id = this.value;
                console.log(category_id)


                $('#animal-feed').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('animal-categories.feeds') }}",
                    type: "get",
                    data: {
                        animal_category_id: category_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#animal-feed').html('<option value="">-- Select animal feed--</option>');

                        $.each(result.animal_feed_categories, function(key, value) {
                            console.log(result)

                            $("#animal-feed").append('<option value="' + value
                                .id + '">' + value.name  + '</option>');

                            console.log('hello', value.name)

                        });

                    }
                });
            });




        })
    </script>



@endpush
