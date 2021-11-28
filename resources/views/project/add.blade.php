@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Projects</li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    @if (count($errors))
        <div class="alert alert-danger">
            <p>Errors: {{ count($errors) }}</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        {{ Form::open(array('route' => array('project::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="form-group row">
            {{ Form::label('name', 'Project Name', array('class' => 'col-3 control-label required-field')) }}
            <div class="col-9">
                {{ Form::text('name', '', array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('proj_number', 'Project Number', array('class' => 'col-3 control-label required-field')) }}
            <div class="col-9">
                {{ Form::text('proj_number', '', array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('workflow_id', 'Workflow', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::select('workflow_id', $workflow_templates, '', array('class' => 'form-control',)) }}
            </div>
        </div>
        <button class="btn btn-primary">Create Project</button>
        {{ Form::close() }}
    </div>
@endsection
