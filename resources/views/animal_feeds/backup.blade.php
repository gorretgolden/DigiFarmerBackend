<?php
$regions = App\Models\Region::orderBy('name', 'ASC')->get();
?>

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h1>Animal Feeds</h1>
                </div>


                <div class="col-md-4 float-right">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <select id='status' name='status' class="form-control " style="width: 100px"
                                    required="">
                                    <option value="1">Status</option>
                                    <option value="2">on-sale</option>
                                    <option value="3">sold</option>

                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">

                                <select id='region_id' name="region_id" class="form-control mr-3" style="width: 150px">
                                    <option value="">Region</option>
                                    @foreach ($regions as $region)
                                        <option value='{{ $region->id }}'>{{ $region->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4 float-right">

                            <div class="form-group">
                                <select id='district_id' name="district_id" class="form-control ml-3" style="width: 150px">
                                    <option value="">District</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-sm-3">

                    <a href="#" class="btn btn-success filter-data  ml-5 form-btn">Filter <i class="fa fa-filter"></i></a>

                    <a class="btn btn-success float-right" href="{{ route('animalFeeds.create') }}">
                        Add New
                    </a>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                {{-- @include('animal_feeds.table') --}}

                <div class="table-responsive">
                    <table class="table " id="data-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Weight</th>
                                <th>Status</th>
                                <th>Vendor</th>
                                <th>Contact</th>
                                <th>Location</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>


            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            //Load the table with all transfers
           // table_results();

            $('#region_id').on('change', function() {
                var region_id = this.value;

                $('#district_id').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('region.districts') }}",
                    type: "get",
                    data: {
                        region_id: region_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#district_id').html(
                            '<option value="">Select district</option>');

                        $.each(result.districts, function(key, value) {
                            console.log(result)


                            $("#district_id").append('<option value="' + value
                                .id + '">' + value.name + " " + '</option>');

                        });

                    }
                });
            });


            // table_results();
            // function table_results(region_id = ' ', status = ' ', country_id = ' ') {
            //     var region_id = this.value;
            //     var status = $("#status option:selected").text();

            //     var table = $('#data-table').DataTable({
            //         dom: "lBfrtip",
            //         buttons: [
            //             'copy', 'excel', 'pdf'
            //         ],
            //         lengthMenu: [
            //             [10, 25, 50, 100, -1],
            //             [10, 25, 50, 100, "All"]
            //         ],
            //         processing: true,
            //         serverSide: true,
            //         ajax: {
            //             url: "{{ route('animalFeeds.index') }}",
            //             data: {
            //                 region_id: region_id,
            //                 status: status,
            //                 district_id: district_id,

            //             },
            //         },
            //         columns: [{
            //                 data: 'image'
            //             },
            //             {
            //                 data: 'name'
            //             },
            //             {
            //                 data: 'category'
            //             },
            //             {
            //                 data: 'price'
            //             },
            //             {
            //                 data: 'stock_amount'
            //             },
            //             {
            //                 data: 'weight'
            //             },
            //             {
            //                 data: 'status'
            //             },
            //             {
            //                 data: 'vendor'
            //             },
            //             {
            //                 data: 'contact'
            //             }
            //             {
            //                 data: 'location'
            //             }

            //         ]
            //     });
            // }
            // //Filter Data Button
            // $('.filter-data').click(function() {

            //     //Getting the Status
            //     var status = $("#status option:selected").text();
            //     var region = $('#region_id').val()
            //     var district = $('#district_id').val()

            //     //Checking if the Status is set
            //     if (status != " " || branch != '') {
            //         $('#data-table').DataTable().destroy();
            //         table_results(status, region, district);

            //     } else {

            //         alert('Select an  option')

            //     }
            // });
        });
    </script>
@endpush
