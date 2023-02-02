<?php
$days= App\Models\Day::pluck('name','id');
$vet_services = App\Models\Veterinary::pluck('name','id');
?>



{{--
<!-- Day Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day_id', 'Day:') !!}
    {!! Form::select('day_id', $days, null, ['class' => 'form-control custom-select']) !!}
</div> --}}


<!--  Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Starting Date:') !!}
    {!! Form::text('date', null, [
        'class' => 'form-control',
        'id' => 'date',
        'placeholder' => 'Select appointment date',
    ]) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#date').datetimepicker({
            format: 'DD-MM-YYYY',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush



<!-- Agronomist Vendsor Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('veterinary_id', 'Veterinary Service:') !!}
    {!! Form::select('veterinary_id', $vet_services, null, ['class' => 'form-control custom-select']) !!}
</div>


<div class="form-group col-sm-12">
    {!! Form::label('agronomist_vendor_service_id', 'Generate slots:') !!}
</div>










<!-- Starting Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_time', 'Starting Time:') !!}
    {!! Form::text('starting_time', null, ['class' => 'form-control','id'=>'starting_time','placeholder'=>'Select starting time']) !!}
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#starting_time').datetimepicker({
            format: 'hh:mm A',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush




<!-- Ending Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ending_time', 'Ending Time:') !!}
    {!! Form::text('ending_time', null, [
        'class' => 'form-control',
        'id' => 'ending_time',
        'placeholder' => 'Select ending time',
    ]) !!}
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#ending_time').datetimepicker({
            format: 'hh:mm A',
            useCurrent: true,
            sideBySide: true
        })
    </script>




@endpush
<!-- interval Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time_interval', 'time_interval:') !!}
    {!! Form::select('time_interval',['20'=>30,'30'=>40], null, ['class' => 'form-control custom-select']) !!}
</div>




{{--


<div class="card">
    <div class="card-header">
        Choose AM Time
        <span class="ml-auto">Check/Uncheck
            <input type="checkbox"
                onclick=" for(c in document.getElementsByName('time[]')) document.getElementsByName('time[]').item(c).checked=this.checked">
        </span>
    </div>
    <div class="card-body">


        <table class="table table-striped">




            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td><input type="checkbox" name="time[]" value="6am"> 6:00am</td>
                    <td><input type="checkbox" name="time[]" value="6.20am"> 6:20am</td>
                    <td><input type="checkbox" name="time[]" value="6.40am"> 6:40am</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td><input type="checkbox" name="time[]" value="7am"> 7:00am</td>
                    <td><input type="checkbox" name="time[]" value="7.20am"> 7:20am</td>
                    <td><input type="checkbox" name="time[]" value="7.40am"> 7:40am</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td><input type="checkbox" name="time[]" value="8am"> 8:00am</td>
                    <td><input type="checkbox" name="time[]" value="8.20am"> 8:20am</td>
                    <td><input type="checkbox" name="time[]" value="8.40am"> 8:40am</td>
                </tr>


                <tr>
                    <th scope="row">4</th>
                    <td><input type="checkbox" name="time[]" value="9am"> 9:00am</td>
                    <td><input type="checkbox" name="time[]" value="9.20am"> 9:20am</td>
                    <td><input type="checkbox" name="time[]" value="9.40am"> 9:40am</td>
                </tr>


                <tr>
                    <th scope="row">5</th>
                    <td><input type="checkbox" name="time[]" value="10am"> 10:00am</td>
                    <td><input type="checkbox" name="time[]" value="10.20am"> 10:20am</td>
                    <td><input type="checkbox" name="time[]" value="10.40am"> 10:40am</td>
                </tr>


                <tr>
                    <th scope="row">6</th>
                    <td><input type="checkbox" name="time[]" value="11am"> 11:00am</td>
                    <td><input type="checkbox" name="time[]" value="11.20am"> 11:20am</td>
                    <td><input type="checkbox" name="time[]" value="11.40am"> 11:40am</td>
                </tr>




            </tbody>
        </table>
    </div>
</div>


<div class="card ml-5">
    <div class="card-header">
        Choose PM Time
    </div>
    <div class="card-body">


        <table class="table table-striped">




            <tbody>
                <tr>
                    <th scope="row">7</th>
                    <td><input type="checkbox" name="time[]" value="12pm"> 12pm</td>
                    <td><input type="checkbox" name="time[]" value="12.20pm"> 12.20pm</td>
                    <td><input type="checkbox" name="time[]" value="12.40pm"> 12.40pm</td>
                </tr>
                <tr>
                    <th scope="row">7</th>
                    <td><input type="checkbox" name="time[]" value="1pm"> 1pm</td>
                    <td><input type="checkbox" name="time[]" value="1.20pm"> 1.20pm</td>
                    <td><input type="checkbox" name="time[]" value="1.40pm"> 1.40pm</td>
                </tr>
                <tr>
                    <th scope="row">8</th>
                    <td><input type="checkbox" name="time[]" value="2pm"> 2pm</td>
                    <td><input type="checkbox" name="time[]" value="2.20pm"> 2.20pm</td>
                    <td><input type="checkbox" name="time[]" value="2.40pm"> 2.40pm</td>
                </tr>
                <tr>
                    <th scope="row">9</th>
                    <td><input type="checkbox" name="time[]" value="3pm"> 3pm</td>
                    <td><input type="checkbox" name="time[]" value="3.20pm"> 3.20pm</td>
                    <td><input type="checkbox" name="time[]" value="3.40pm"> 3.40pm</td>
                </tr>
                <tr>
                    <th scope="row">10</th>
                    <td><input type="checkbox" name="time[]" value="4pm"> 4pm</td>
                    <td><input type="checkbox" name="time[]" value="4.20pm"> 4.20pm</td>
                    <td><input type="checkbox" name="time[]" value="4.40pm"> 4.40pm</td>
                </tr>
                <tr>
                    <th scope="row">11</th>
                    <td><input type="checkbox" name="time[]" value="5pm"> 5pm</td>
                    <td><input type="checkbox" name="time[]" value="5.20pm"> 5.20pm</td>
                    <td><input type="checkbox" name="time[]" value="5.40pm"> 5.40pm</td>
                </tr>
                <tr>
                    <th scope="row">12</th>
                    <td><input type="checkbox" name="time[]" value="6pm"> 6pm</td>
                    <td><input type="checkbox" name="time[]" value="6.20pm"> 6.20pm</td>
                    <td><input type="checkbox" name="time[]" value="6.40pm"> 6.40pm</td>
                </tr>
                <tr>
                    <th scope="row">13</th>
                    <td><input type="checkbox" name="time[]" value="7pm"> 7pm</td>
                    <td><input type="checkbox" name="time[]" value="7.20pm"> 7.20pm</td>
                    <td><input type="checkbox" name="time[]" value="7.40pm"> 7.40pm</td>
                </tr>
                <tr>
                    <th scope="row">14</th>
                    <td><input type="checkbox" name="time[]" value="8pm"> 8pm</td>
                    <td><input type="checkbox" name="time[]" value="8.20pm"> 8.20pm</td>
                    <td><input type="checkbox" name="time[]" value="8.40pm"> 8.40pm</td>
                </tr>
                <tr>
                    <th scope="row">15</th>
                    <td><input type="checkbox" name="time[]" value="9pm"> 9pm</td>
                    <td><input type="checkbox" name="time[]" value="9.20pm"> 9.20pm</td>
                    <td><input type="checkbox" name="time[]" value="9.40pm"> 9.40pm</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> --}}


