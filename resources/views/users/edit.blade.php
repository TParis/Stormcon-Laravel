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
    {{ Form::open(array('route' => array('users::update', $user->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
        <div class="panel-heading">
            <h2>Edit User</h2>
        </div>
        <div class="panel-body">
            <div class="form-group">
                {{ Form::label('name', 'Username', array('class' => 'col-sm-2 control-label required-field required-field')) }}
                <div class="col-sm-10">
                    {{ Form::text('name', $user->name, array('class' => 'form-control', 'placeholder' => 'Username')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('first_name', 'First name', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::text('first_name', $user->first_name, array('class' => 'form-control', 'placeholder' => 'First name')) }}
                </div>
                {{ Form::label('last_name', 'Last name', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-4">
                    {{ Form::text('last_name', $user->last_name, array('class' => 'form-control', 'placeholder' => 'Last name')) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-10">
                    {{ Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => 'email@address.com')) }}
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a href="{{route('users::view', $user->id)}}" class="btn btn-danger"><i class="fa fa-stop-circle"></i> Cancel</a>
            <button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-pencil"></i> Update</button>
        </div>
    {{ Form::close() }}
</div>

