<div class="operator-{{ $iter }}" id="operator-{{$iter}}">
    <h3>{{ $operator->{'operator_' . $operator->index . '_role'} }}</h3>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_role', 'Role', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('operator_' . $operator->index . '_role', $roles, $operator->{'operator_' . $operator->index . '_role'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('operator_' . $operator->index . '_name', $companies, $operator->{'operator_' . $operator->index . '_name'}, array('class' => 'form-control company-select',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_legal_name', $operator->{'operator_' . $operator->index . '_legal_name'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_also_known_as', $operator->{'operator_' . $operator->index . '_also_known_as'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_phone', $operator->{'operator_' . $operator->index . '_phone'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_fax', $operator->{'operator_' . $operator->index . '_fax'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_website', $operator->{'operator_' . $operator->index . '_website'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_address', $operator->{'operator_' . $operator->index . '_address'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_city', $operator->{'operator_' . $operator->index . '_city'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('operator_' . $operator->index . '_state', $states, $operator->{'operator_' . $operator->index . '_state'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_zipcode', 'Zip Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_zipcode', $operator->{'operator_' . $operator->index . '_zipcode'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_federal_tax_id', $operator->{'operator_' . $operator->index . '_federal_tax_id'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_state_tax_id', $operator->{'operator_' . $operator->index . '_state_tax_id'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_type', $operator->{'operator_' . $operator->index . '_type'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::number('operator_' . $operator->index . '_num_of_employees', $operator->{'operator_' . $operator->index . '_num_of_employees'}, array('class' => 'form-control',)) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_division', $operator->{'operator_' . $operator->index . '_division'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_sos', $operator->{'operator_' . $operator->index . '_sos'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_cn', $operator->{'operator_' . $operator->index . '_cn'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('operator_' . $operator->index . '_sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('operator_' . $operator->index . '_sic', $operator->{'operator_' . $operator->index . '_sic'}, array('class' => 'form-control')) }}
        </div>
    </div>
</div>
