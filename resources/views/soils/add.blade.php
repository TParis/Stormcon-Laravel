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
    {{ Form::open(array('route' => array('soils::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="form-group row">
            {{ Form::label('name', 'Name', array('class' => 'col-4 control-label required-field')) }}
            <div class="col-8">
                {{ Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Name of Soil')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('group', 'Hydrologic Group', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('group', '', array('class' => 'form-control', 'placeholder' => 'D')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('k', 'K-Factor', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('k', '', array('class' => 'form-control', 'placeholder' => '0.0')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('sand', 'Sand %', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('sand', '', array('class' => 'form-control', 'placeholder' => '0.0')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('silt', 'Silt %', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('silt', '', array('class' => 'form-control', 'placeholder' => '0.0')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('clay', 'Clay %', array('class' => 'col-4 control-label')) }}
            <div class="col-8">
                {{ Form::text('clay', '', array('class' => 'form-control', 'placeholder' => '0.0')) }}
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
