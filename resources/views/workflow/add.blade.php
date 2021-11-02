@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ Route("workflow_template::index") }}">Workflow Templates</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
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
        {{ Form::open(array('route' => array('workflow_template::store'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
        <div class="form-group row">
            {{ Form::label('name', 'Template Name', array('class' => 'col-3 control-label required-field')) }}
            <div class="col-9">
                {{ Form::text('name', '', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row d-none">
            {{ Form::label('priority', 'Priority', array('class' => 'col-3 control-label')) }}
            <div class="col-9">
                {{ Form::hidden('priority', 2, array('class' => 'form-control', 'placeholder' => 'First name')) }}
            </div>
        </div>
        <button class="btn btn-primary">Create Template</button>
        {{ Form::close() }}
    </div>
@endsection
