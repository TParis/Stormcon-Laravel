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
    {{ Form::open(['route' => ['pollutants::create'], 'method' => 'post', 'class' => 'form-horizontal']) }}
    <div class="form-group row">
        {{ Form::label('name', 'Name', ['class' => 'col-4 control-label required-field']) }}
        <div class="col-8">
            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name of Pollutant']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('source', 'Source', ['class' => 'col-4 control-label']) }}
        <div class="col-8">
            {{ Form::text('source', '', ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('material', 'Material', ['class' => 'col-4 control-label']) }}
        <div class="col-8">
            {{ Form::text('material', '', ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('average', 'Average', ['class' => 'col-4 control-label']) }}
        <div class="col-8">
            {{ Form::number('average', '', ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-6 p-2 text-center">
            <button type="button" class="btn btn-primary w-100" data-dismiss="modal">Close</button>
        </div>
        <div class="col-6 p-2 text-center">
            <input type="submit" class="btn btn-success w-100" value="Save Changes"/>
        </div>
    </div>
    {{ Form::close() }}
</div>
