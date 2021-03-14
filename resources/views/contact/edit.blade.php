@if (count($errors))
    <p>Errors: {{ count($errors) }}</p>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid">
    {{ Form::open(array('route' => array('contact::update', $contact->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
    <div class="form-group row">
        {{ Form::label('first_name', 'First Name', array('class' => 'col-4 control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('first_name', $contact->first_name, array('class' => 'form-control', 'placeholder' => 'First')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('last_name', 'Last Name', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('last_name', $contact->last_name, array('class' => 'form-control', 'placeholder' => 'Last')) }}
        </div>
    </div>
    <div class="form-group row">
        @if ($contact->employer->getMorphClass() == "App\Models\Company")
        <div class="col-4 control-label">
            Company
        </div>
        <div class="col-8">
            <a href="{{ route("company::view", $contact->employer->id) }}">{{ $contact->employer->name }}</a>
        </div>
        @else
        <div class="col-4 control-label">
            Municipal
        </div>
        <div class="col-8">
            <a href="{{ route("municipal::view", $contact->employer->id) }}">{{ $contact->employer->name }}</a>
        </div>
        @endif
    </div>
    <div class="form-group row">
        {{ Form::label('phone', 'Phone Number', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('phone', $contact->phone, array('class' => 'form-control', 'placeholder' => '210-351-3518')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('cell', 'Cell Phone', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('cell', $contact->cell, array('class' => 'form-control', 'placeholder' => '210-351-3518')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('email', 'Email Address', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::email('email', $contact->email, array('class' => 'form-control', 'placeholder' => 'test@test.com')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('title', 'Title', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('title', $contact->title, array('class' => 'form-control', 'placeholder' => 'Manager')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('division', 'Division', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('division', $contact->division, array('class' => 'form-control', 'placeholder' => 'Gas Provider')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('er', 'ER Number', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('er', $contact->er, array('class' => 'form-control', 'placeholder' => 'ASB654646')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('epa', 'EPA Number', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('epa', $contact->epa, array('class' => 'form-control', 'placeholder' => '254354AS')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('noi', 'NOI Signer', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::select('noi', [1 =>'Yes', 0 => 'No'], $contact->noi, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('inspector', 'Inspector', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::select('inspector', [1 =>'Yes', 0 => 'No'], $contact->inspector, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('qualifications', 'Qualifications', array('class' => 'col-4 control-label')) }}
        <div class="col-8">
            {{ Form::text('qualifications', $contact->qualifications, array('class' => 'form-control', 'placeholder' => 'Description')) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteContact({{ $contact->id }}, '{{ $contact->name }}')" class="btn btn-danger w-100">Delete</a>
        </div>
        <div class="col-4 p-2 text-center">
            <button type="button" class="btn btn-primary w-100" data-dismiss="modal">Close</button>
        </div>
        <div class="col-4 p-2 text-center">
            <input type="submit" class="btn btn-success w-100" value="Save Changes" />
        </div>
    </div>
    {{ Form::close() }}
</div>

