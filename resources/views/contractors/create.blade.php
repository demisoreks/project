@extends('app', ['page_title' => 'Contractors'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('contractors.index') }}"><i class="fas fa-list"></i> Existing Contractors</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Contractor</legend>
        {!! Form::model(new App\Contractor, ['route' => ['contractors.store'], 'class' => 'form-group']) !!}
            @include('contractors/form', ['submit_text' => 'Create Contractor'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
