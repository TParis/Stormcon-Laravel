@if (count($errors))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="panel panel-default">
    {{ Form::open(array('route' => array('users::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="panel-heading">
            <h2>Add User</h2>
        </div>
        <div class="panel-body">
            <div class="form-group">
                {{ Form::label('name', 'Username', array('class' => 'col-sm-2 control-label required-field')) }}
                <div class="col-sm-10">
                    {{ Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Username')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('first_name', 'First name', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::text('first_name', '', array('class' => 'form-control', 'placeholder' => 'First name')) }}
                </div>
                {{ Form::label('last_name', 'Last name', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::text('last_name', '', array('class' => 'form-control', 'placeholder' => 'Last name')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'email@address.com')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('phone_number', 'Phone number', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::text('phone_number', '', array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
                </div>
                {{ Form::label('fax_number', 'Fax number', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::text('fax_number', '', array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('company_id', 'Company', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::select('company_id', $companies, '', array('class' => 'form-control', 'placeholder' => 'Please select company')) }}
                </div>
                {{ Form::label('role', 'Access level', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::select('role', $roles, '', array('class' => 'form-control')) }}
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a href="{{ route('users::index') }}" class="btn btn-danger"><i class="fa fa-stop-circle"></i> Cancel</a>
            <button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-pencil"></i> Submit</button>
        </div>
    {{ Form::close() }}
</div>
