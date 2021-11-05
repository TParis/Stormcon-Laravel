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
    {{ Form::open(array('route' => array('roles::update', $role->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
    <div class="form-group row">
        {{ Form::label('name', 'Name', array('class' => 'col-4 control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('name', $role->name, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button" onClick="deleteRoles({{ $role->id }}, '{{ $role->name }}')" class="btn btn-danger w-100">Delete</a>
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

