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
    {{ Form::open(array('route' => array('schedule::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="form-group row">
            {{ Form::label('Name', 'Name', array('class' => 'col-4 control-label required-field')) }}
            <div class="col-8">
                {{ Form::text('Name', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('days', 'Schedule', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::select('days', $days, '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Description', 'Description', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('Description', '', array('class' => 'form-control')) }}
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
