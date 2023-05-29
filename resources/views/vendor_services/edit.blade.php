@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Vendor Service</h1>
                    <div>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="#">{{ $vendorService->sub_category->category->name }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $vendorService->sub_category->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($vendorService, [
                'route' => ['vendorServices.update', $vendorService->id],
                'method' => 'patch',
                'files' => true,
            ]) !!}

            <div class="card-body">
                <div class="row">
                    @include('vendor_services.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('vendorServices.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
