
<?php
$regions = App\Models\Region::pluck('name','id');
$users = App\Models\User::where('user_type','farmer')->pluck('username','id');
?>

<!-- Country Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('region_id', 'Region:') !!}
    {!! Form::select('region_id', $regions, null, ['class' => 'form-control custom-select']) !!}
</div>


<!--district-->
<div class="form-group col-sm-6">
    {!! Form::label('district_id', 'District:') !!}
    <select id="region-district" name="district_id" class="form-control">


    </select>
</div>



<!-- Address Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_name', 'Address Name:') !!}
    {!! Form::text('address_name', null, ['class' => 'form-control']) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>



@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {


            $('#region_id').on('change', function() {
                var idRegion = this.value;
                console.log(idRegion)


                $('#region-district').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('region.districts') }}",
                    type: "get",
                    data: {
                        region_id: idRegion
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#region-district').html(
                            '<option value="">-- Select district --</option>');


                        $.each(result.districts, function(key, value) {
                            console.log(result)


                            $("#region-district").append('<option value="' + value
                                .id + '">' +  value
                                .name + '</option>');


                            console.log('hello', value.name)


                        });


                    }
                });
            });



        })
    </script>



@endpush
