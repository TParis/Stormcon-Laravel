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
@php
    /**
     * @var \App\Models\Pollutant  $pollutant
     */
@endphp
<div class="container-fluid">
    {{ Form::open(['route' => ['pollutants::update', $pollutant->id], 'method' => 'put', 'class' => 'form-horizontal']) }}
    <div class="form-group row">
        {{ Form::label('name', 'Name', ['class' => 'col-4 control-label required-field']) }}
        <div class="col-8">
            {{ Form::text('name', $pollutant->{$pollutant::COLUMNS['name']}, ['class' => 'form-control', 'placeholder' => 'Name of Pollutant']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('source', 'Source', ['class' => 'col-4 control-label']) }}
        <div class="col-8">
            {{ Form::text('source', $pollutant->{$pollutant::COLUMNS['source']}, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('material', 'Material', ['class' => 'col-4 control-label']) }}
        <div class="col-8">
            {{ Form::text('material', $pollutant->{$pollutant::COLUMNS['material']}, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('average', 'Average', ['class' => 'col-4 control-label']) }}
        <div class="col-8">
            {{ Form::number('average', $pollutant->{$pollutant::COLUMNS['average']}, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4 p-2 text-center">
            <a type="button"
               onClick="deletePollutant({{ $pollutant->id }}, '{{ $pollutant->{$pollutant::COLUMNS['name']} }}')"
               class="btn btn-danger w-100">Delete</a>
        </div>
        <div class="col-4 p-2 text-center">
            <button type="button" class="btn btn-primary w-100" data-dismiss="modal">Close</button>
        </div>
        <div class="col-4 p-2 text-center">
            <input type="submit" class="btn btn-success w-100" value="Save Changes"/>
        </div>
    </div>
    {{ Form::close() }}
</div>

