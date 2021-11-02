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
    {{ Form::open(array('route' => array('users::update', $user->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
    <div class="form-group row">
        {{ Form::label('username', 'Username', array('class' => 'col-3 control-label required-field')) }}
        <div class="col-9">
            {{ Form::text('username', $user->username, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('fullName', 'Full name', array('class' => 'col-3 control-label')) }}
        <div class="col-9">
            {{ Form::text('fullName', $user->fullName, array('class' => 'form-control', 'placeholder' => 'First name')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('email', 'Email', array('class' => 'col-3 control-label')) }}
        <div class="col-9">
            {{ Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => 'email@address.com')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('phone', 'Phone number', array('class' => 'col-3 control-label')) }}
        <div class="col-9">
            {{ Form::text('phone', $user->phone, array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('active', 'Account Active', array('class' => 'col-3 control-label')) }}
        <div class="col-9">
            {{ Form::select('active', [0 => "No", 1 => "Yes"], $user->active, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('roles[]', 'Roles', array('class' => 'col-3 control-label')) }}
        <div class="col-9">
            {{ Form::select('roles[]', $roles, $user->getRoleNames()->toArray(), array('class' => 'form-control', 'multiple' => 'multiple')) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteUser({{ $user->id }}, '{{ $user->username }}')" class="btn btn-danger w-100">Delete</a>
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

