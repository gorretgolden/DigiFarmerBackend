
<?php
$permissions = Spatie\Permission\Models\Permission::pluck('name','id');

?>
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Role</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'roles.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('roles.fields')

                    <div class="col-md-8">
                        <strong>Permission:</strong>
                        <br/>

                        @foreach ($permissions as  $key => $value )
                      <div class="display:grid;grid-template-columns:repeat(2,1fr)">
                        <label class="label label-success">
                            {{!! Form::checkbox('permission[]', $value, false, array('class','permission')) !!}}
                             {{$value}}</label>
                        <br/>

                      </div>
                        @endforeach


                    </div>
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('roles.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
