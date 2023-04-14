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
    {{ Form::open(array('route' => array('bmps::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="form-group row">
            {{ Form::label('name', 'Name', array('class' => 'col-4 control-label required-field')) }}
            <div class="col-8">
                {{ Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Name of BMP')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('description', 'Description', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('description', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('uses', 'Uses', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('uses', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('inspection_schedule', 'Inspection Schedule', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('inspection_schedule', '', array('class' => 'form-control', 'placeholder' => 'Inspection Schedule')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('maintenance', 'Maintenance', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('maintenance', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('installation_schedule', 'Installation Schedule', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('installation_schedule', '', array('class' => 'form-control', 'placeholder' => 'Installation Schedule')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('considerations', 'Considerations', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('considerations', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('interim_or_permanent', 'Interim/Permanent', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::select('interim_or_permanent', $interim_or_permanent_choices ?? \App\Models\bmp::getInterimOrPermanentChoices(), '', array('class' => 'form-control')) }}
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
