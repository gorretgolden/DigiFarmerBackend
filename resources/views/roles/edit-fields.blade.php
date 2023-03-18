<?php
$permissions = Spatie\Permission\Models\Permission::orderBy('created_at','ASC')->get();
#use Spatie\Permission\Models\Permission;
?>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/roles.fields.name') . ':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Guard Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('guard_name', __('models/roles.fields.guard_name') . ':') !!}
    {!! Form::text('guard_name', null, ['class' => 'form-control', 'placeholder' => 'web', 'readonly']) !!}
</div>




<!--permissions-->
<div class="col-md-12 mt-3 ml-2">
    {{-- @foreach ($permissions as $permission)
        <div class="checkbox">
            <label>
                {{ ucfirst($permission->name) }}
            </label>
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                @if ($role->permissions->contains($permission)) checked @endif>


        </div>
    @endforeach --}}


    @foreach ($permissions->chunk(3) as $chunk)
        <div class="row">
            @foreach ($chunk as $permission)
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="checkbox">
                        <label>
                            {{ ucfirst($permission->name) }}
                        </label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            >
                            <?php
                            dd($role->permissions())

                            ?>


                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>


</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('roles.index') }}" class="btn btn-light">@lang('crud.cancel')</a>
</div>

</div>
