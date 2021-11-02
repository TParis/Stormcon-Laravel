@if (count($errors))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid">
    @if (isset($company))
    {{ Form::open(array('route' => array('company::addContact', $company->id), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
    @else
    {{ Form::open(array('route' => array('municipal::addContact', $municipal->id), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
    @endif
        <div class="form-group row">
            {{ Form::label('first_name', 'First Name', array('class' => 'col-4 control-label required-field')) }}
            <div class="col-8">
                {{ Form::text('first_name', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('last_name', 'Last Name', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('last_name', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            @if (isset($company))
                <div class="col-4 control-label">
                    Company
                </div>
                <div class="col-8">
                    {{ $company->name }}
                </div>
            @else
                <div class="col-4 control-label">
                    Municipal
                </div>
                <div class="col-8">
                    {{ $municipal->name }}
                </div>
            @endif
        </div>
        <div class="form-group row">
            {{ Form::label('phone', 'Phone Number', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('phone', '', array('class' => 'form-control', 'placeholder' => '210-351-3518')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('cell', 'Cell Phone', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('cell', '', array('class' => 'form-control', 'placeholder' => '210-351-3518')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('email', 'Email Address', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'test@test.com')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('title', 'Title', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('title', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('division', 'Division', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('division', '', array('class' => 'form-control', 'placeholder' => 'Gas Provider')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('er', 'ER Number', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('er', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('epa', 'EPA Number', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('epa', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('noi', 'NOI Signer', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::select('noi', [1 =>'Yes', 0 => 'No'], [0], array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('inspector', 'Inspector', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::select('inspector', [1 =>'Yes', 0 => 'No'], [0], array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('qualifications', 'Qualifications', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('qualifications', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-6 p-2 text-center">
                <button type="button" class="btn btn-primary w-100" data-dismiss="modal">Close</button>
            </div>
            <div class="col-6 p-2 text-center">
                <input type="submit" class="btn btn-success w-100" value="Save Changes" />
            </div>
        </div>
    {{ Form::close() }}
</div>
