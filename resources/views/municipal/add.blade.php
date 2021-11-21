@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("municipal::index") }}">Municipals</a></li>
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
        <div class="card ml-auto mr-auto w-75">
            <div class="card-body">
                <h5 class="card-title">Add Municipal</h5>
                {{ Form::open(array('route' => array('municipal::create'), 'method' => 'post', 'class' => 'form-horizontal')) }}
                <div class="form-group row">
                    {{ Form::label('name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('name', '', array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('phone', '', array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123-456-7890')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('address', '', array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('city', '', array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::select('state', $states, 'TX', array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('zipcode', 'Zip Code', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('zipcode', '', array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6 p-2 text-center">
                        <button type="button" class="btn btn-primary w-100">Close</button>
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
