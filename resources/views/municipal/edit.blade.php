@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("municipal::index") }}">Municipals</a></li>
        <li class="breadcrumb-item">{{ $municipal->name }}</li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                <h5 class="card-title">Edit Municipal</h5>
                {{ Form::open(array('route' => array('municipal::update', $municipal->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
                <div class="form-group row">
                    {{ Form::label('name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('name', $municipal->name, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('phone', $municipal->phone, array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123-456-7890')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('address', $municipal->address, array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('city', $municipal->city, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::select('state', $states, $municipal->state, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('zipcode', 'Zip Code', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('zipcode', $municipal->zipcode, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4 p-2 text-center">
                        <a type="button" onClick="deleteCounty({{ $municipal->id }}, '{{ $municipal->name }}')" class="btn btn-danger w-100">Delete</a>
                    </div>
                    <div class="col-4 p-2 text-center">
                        <a href="{{ route("municipal::view", $municipal->id) }}" type="button" class="btn btn-primary w-100">Close</a>
                    </div>
                    <div class="col-4 p-2 text-center">
                        <input type="submit" class="btn btn-success w-100" value="Save Changes" />
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
