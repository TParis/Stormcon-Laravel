<div class="provider-{{ $iter }}" id="provider-{{$iter}}">
    <h3>New Operator</h3>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_role', 'Role', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('provider_' . $iter . '_role', $roles, [], array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('provider_' . $iter . '_name', $companies, [], array('class' => 'form-control company-select',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_legal_name', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_also_known_as', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_phone', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_fax', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_website', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_address', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_city', "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('provider_' . $iter . '_state', $states, "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_zipcode', 'Zip Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_zipcode', "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_federal_tax_id', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_state_tax_id', "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_type', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::number('provider_' . $iter . '_num_of_employees', "", array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_division', "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_sos', "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_cn', "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $iter . '_sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $iter . '_sic', "", array('class' => 'form-control')) }}
        </div>
    </div>
</div>
