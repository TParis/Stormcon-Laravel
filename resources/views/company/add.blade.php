@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("company::index") }}">Companies</a></li>
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
                <h5 class="card-title">Add County</h5>
                {{ Form::open(array('route' => array('company::create'), 'method' => 'post', 'class' => 'form-horizontal')) }}
                <div class="form-group row">
                    {{ Form::label('name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('name', '', array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('legal_name', '', array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('also_known_as', '', array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('phone', '', array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123-456-7890')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('fax', '', array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('website', '', array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
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
                        {{ Form::text('city', '', array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Dallas')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::select('state', $states, 'TX', array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('zipcode', 'Zipcode', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('zipcode', '', array('required' => 'required', 'class' => 'form-control', 'placeholder' => '78123')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('federal_tax_id', '', array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('state_tax_id', '', array('class' => 'form-control', 'placeholder' => '1231564897')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('type', '', array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::number('num_of_employees', '', array('class' => 'form-control', 'placeholder' => '5')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('division', '', array('class' => 'form-control', 'placeholder' => 'Residential')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('sos', '', array('class' => 'form-control', 'placeholder' => '23123483')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('cn', '', array('class' => 'form-control', 'placeholder' => '1315547354')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('sic', '', array('class' => 'form-control', 'placeholder' => 'B3B354ASD')) }}
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
