@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item"><a href="{{ route("company::index") }}">Companies</a></li>
        <li class="breadcrumb-item">{{ $company->name }}</li>
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
                <h5 class="card-title">Edit Company</h5>
                {{ Form::open(array('route' => array('company::update', $company->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
                <div class="form-group row">
                    {{ Form::label('name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('name', $company->name, array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('legal_name', $company->legal_name, array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('also_known_as', $company->also_known_as, array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('phone', $company->phone, array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123-456-7890')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('fax', $company->fax, array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('website', $company->website, array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('address', $company->address, array('required' => 'required', 'class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('city', $company->city, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::select('state', $states, $company->state, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('zipcode', 'Zip Code', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('zipcode', $company->zipcode, array('required' => 'required', 'class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('federal_tax_id', $company->federal_tax_id, array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('state_tax_id', $company->state_tax_id, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('type', $company->type, array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::number('num_of_employees', $company->num_of_employees, array('class' => 'form-control', 'placeholder' => '5')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('division', $company->division, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('sos', $company->sos, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('cn', $company->cn, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
                    <div class="col-8">
                        {{ Form::text('sic', $company->sic, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4 p-2 text-center">
                        <a type="button" onClick="deleteCompany({{ $company->id }}, '{{ $company->name }}')" class="btn btn-danger w-100">Delete</a>
                    </div>
                    <div class="col-4 p-2 text-center">
                        <a href="{{ route("company::view", $company->id) }}" type="button" class="btn btn-primary w-100">Close</a>
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
