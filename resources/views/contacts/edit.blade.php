@extends('app', ['page_title' => 'Contacts'])

@section('content')
<div class="row">
    <div class="col-12">
        <table class="table table-condensed table-hover table-primary">
            <tr>
                <td><strong>Contractor:</strong> {{ $contractor->name }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('contractors.contacts.index', [$contractor->slug()]) }}"><i class="fas fa-list"></i> Existing Contacts</a>
        <a class="btn btn-primary" href="{{ route('contractors.index') }}"><i class="fas fa-list"></i> Back to Contractors</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Contact</legend>
        {!! Form::model($contact, ['route' => ['contractors.contacts.update', $contractor->slug(), $contact->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('contacts/form', ['submit_text' => 'Update Contact'])
        {!! Form::close() !!}
    </div>
</div>
@endsection