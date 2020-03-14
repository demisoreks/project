@extends('app', ['page_title' => 'Components', 'nest' => 1])

@section('content')
<div class="row">
    <div class="col-12">
        <table class="table table-condensed table-hover table-primary">
            <tr>
                <td><strong>Project:</strong> {{ $project->name }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('projects.components.index', $project->slug()) }}"><i class="fas fa-list"></i> Existing Components</a>
        <a class="btn btn-primary" href="{{ route('projects.index') }}"><i class="fas fa-arrow-left"></i> Back to Projects</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Component</legend>
        {!! Form::model(new App\Component, ['route' => ['projects.components.store', $project->slug()], 'class' => 'form-group']) !!}
            @include('components/form', ['submit_text' => 'Create Component'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
