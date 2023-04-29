<?php
$categories = App\Models\Category::where('is_active', 1)->orderBy('name','ASC')->pluck('name', 'id');

?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6 " id="image-container">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>





<!--  Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', $categories, null, [
        'class' => 'form-control custom-select',
        'placeholder' => 'Select category',
    ]) !!}
</div>


{{-- <!-- Animal Category Id Field -->
<div class="form-group col-sm-6" id="animals-container">
    {!! Form::label('animal_category_id', 'Animal Category:') !!}
    <?php
    $animal_categories = App\Models\AnimalCategory::where('is_active', 1)->pluck('name', 'id');
    ?>
    {!! Form::select('animal_category_id', $animal_categories, null, [
        'class' => 'form-control custom-select',
        'Select an animal category',
        'required'
    ]) !!}
</div> --}}

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>
@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}


    {{-- <script type="text/javascript">
        $(document).ready(function() {

            $('#animals-container').hide()

            $('#category_id').on('change', function() {
                $(this).find("option:selected").text()
                var name = $(this).find("option:selected").text()

                if (name == 'Animal Feeds') {
                    console.log(this.value)
                    $('#animals-container').show()
                    $('#image-container').hide()

                } else {
                    $('#animals-container').hide()

                }


            });



        });
    </script> --}}
@endpush
