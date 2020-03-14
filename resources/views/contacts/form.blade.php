<div class="form-group row">
    {!! Form::label('name', 'Name *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('mobile_number', 'Mobile Number *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('mobile_number', $value = null, ['class' => 'form-control', 'placeholder' => 'Mobile Number', 'required' => true, 'maxlength' => 20]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('email', 'Email Address *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('email', $value = null, ['class' => 'form-control', 'placeholder' => 'Email Address', 'required' => true, 'maxlength' => 50]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>