@extends('app', ['page_title' => 'Updates', 'nest' => 1])

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
        <a class="btn btn-primary" href="{{ route('projects.updates.index', $project->slug()) }}"><i class="fas fa-list"></i> Existing Updates</a>
        <a class="btn btn-primary" href="{{ route('projects.index') }}"><i class="fas fa-arrow-left"></i> Back to Projects</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Update</legend>
        {!! Form::model(new App\Update, ['route' => ['projects.updates.store', $project->slug()], 'class' => 'form-group']) !!}
            @include('updates/form', ['submit_text' => 'Create Update'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
