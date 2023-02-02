<div class="row">
    <div class="col-md-12">
        <!-- Day Id Field -->
        <div class="col-sm-12">
            {!! Form::label('day_id', 'Day :') !!}
            <p>{{ $agronomistShedule->day->name }}</p>
        </div>


        <!-- Start Time Field -->
        <div class="col-sm-12">
            {!! Form::label('start_time', 'Start Time:') !!}
            <p>{{ $agronomistShedule->starting_time }}</p>
        </div>


        <!-- End Time Field -->
        <div class="col-sm-12">
            {!! Form::label('end_time', 'End Time:') !!}
            <p>{{ $agronomistShedule->ending_time }}</p>
        </div>


        <!-- Agronomist Vendor Service Id Field -->
        <div class="col-sm-12">
            {!! Form::label('agronomist_vendor_service_id', 'Agronomist Vendor Service:') !!}
            <p>{{ $agronomistShedule->agronomist_vendor_service->name }}</p>
        </div>


          <!-- Agronomist Vendor Field -->
          <div class="col-sm-12">
            {!! Form::label('agronomist_vendor_service_id', 'Agronomist Vendor :') !!}
            <p>{{ $agronomistShedule->agronomist_vendor_service->user->username }}</p>
        </div>




        <!-- Created At Field -->
        <div class="col-sm-12">
            {!! Form::label('created_at', 'Created At:') !!}
            <p>{{ $agronomistShedule->created_at->format('d/m/Y')}}</p>
        </div>


        <!-- Updated At Field -->
        <div class="col-sm-12">
            {!! Form::label('updated_at', 'Updated At:') !!}
            <p>{{ $agronomistShedule->updated_at }}</p>
        </div>




    </div>






</div>




<!--slots-->
<div class="card  w-100">
    <div class="card-header">
        <h4>Slots</h4>
    </div>
    <div class="card-body">


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Status </th>


                </tr>
            </thead>
            <tbody>
                @foreach ($agronomistShedule->slots as $slot)
                    <tr>
                        <td>{{ $slot->time }}</td>
                        <td>
                            @if ($slot->status==0)
                            <span class="badge rounded-pill bg-success">available</span>


                                @else
                                <span class="badge rounded-pill bg-success">taken</span>
                            @endif
                        </td>


                    </tr>
                @endforeach
            </tbody>


        </table>
    </div>
</div>


