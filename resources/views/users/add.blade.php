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
    {{ Form::open(array('route' => array('users::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="form-group row">
            {{ Form::label('username', 'Username', array('class' => 'col-3 control-label required-field')) }}
            <div class="col-9">
                {{ Form::text('username', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('fullName', 'Full name', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::text('fullName', '', array('class' => 'form-control', 'placeholder' => 'First name')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('email', 'Email', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'email@address.com')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('phone', 'Phone number', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::text('phone', '', array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('active', 'Account Active', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::select('active', [0 => "No", 1 => "Yes"], 0, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('roles[]', 'Roles', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::select('roles[]', $roles, ["None"], array('class' => 'form-control', 'multiple' => 'multiple')) }}
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
