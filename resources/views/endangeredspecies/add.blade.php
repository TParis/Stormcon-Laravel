@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("county::index") }}">Counties</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
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
        <div class="card ml-auto mr-auto w-50">
            <div class="card-body">
                <h5 class="card-title">Add Species</h5>
                {{ Form::open(array('route' => array('species::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
                <div class="form-group row">
                    {{ Form::label('common_name', 'Common Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('common_name', '', array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('scientific_name', 'Scientific Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('scientific_name', '', array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('group', 'Group', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('group', '', array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state_status', 'State Status', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('state_status', '', array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('federal_status', 'Federal Status', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('federal_status', '', array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('species_info', 'Species Info', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('species_info', '', array('class' => 'form-control', 'placeholder' => 'Name of County')) }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6 p-2 text-center">
                        <a href="{{ route("species::index") }}" type="button" class="btn btn-primary w-100">Close</a>
                    </div>
                    <div class="col-6 p-2 text-center">
                        <input type="submit" class="btn btn-success w-100" value="Save Changes" />
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
