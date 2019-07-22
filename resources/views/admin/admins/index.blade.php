@extends('admin.index')

@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $title }}</h3>
    </div>

    <div class="box-body">

        {!! $dataTable->table([
        'class' => 'dataTable table table-striped table-bordered table-hover'
        ]) !!}

    </div>
</div>

@push('js')
    {!! $dataTable->scripts() !!}
@endpush

@endsection
