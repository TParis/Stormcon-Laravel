<div class="contractor-{{ $iter }}" id="contractor-{{$iter}}">
    <h3>{{ $contractor->{'contractor_' . $contractor->index . '_role'} }}</h3>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_role', 'Role', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->index . '_role', $roles, $contractor->{'contractor_' . $contractor->index . '_role'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->index . '_name', $companies, $contractor->{'contractor_' . $contractor->index . '_name'}, array('class' => 'form-control company-select', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_legal_name', $contractor->{'contractor_' . $contractor->index . '_legal_name'}, array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_also_known_as', $contractor->{'contractor_' . $contractor->index . '_also_known_as'}, array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_phone', $contractor->{'contractor_' . $contractor->index . '_phone'}, array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_fax', $contractor->{'contractor_' . $contractor->index . '_fax'}, array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_website', $contractor->{'contractor_' . $contractor->index . '_website'}, array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_address', $contractor->{'contractor_' . $contractor->index . '_address'}, array('class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_city', $contractor->{'contractor_' . $contractor->index . '_city'}, array('class' => 'form-control', 'placeholder' => 'Dallas')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->index . '_state', $states, $contractor->{'contractor_' . $contractor->index . '_state'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_zipcode', 'Zipcode', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_zipcode', $contractor->{'contractor_' . $contractor->index . '_zipcode'}, array('class' => 'form-control', 'placeholder' => '78123')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_federal_tax_id', $contractor->{'contractor_' . $contractor->index . '_federal_tax_id'}, array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_state_tax_id', $contractor->{'contractor_' . $contractor->index . '_state_tax_id'}, array('class' => 'form-control', 'placeholder' => '1231564897')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_type', $contractor->{'contractor_' . $contractor->index . '_type'}, array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::number('contractor_' . $contractor->index . '_num_of_employees', $contractor->{'contractor_' . $contractor->index . '_num_of_employees'}, array('class' => 'form-control', 'placeholder' => '5')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_division', $contractor->{'contractor_' . $contractor->index . '_division'}, array('class' => 'form-control', 'placeholder' => 'Residential')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_sos', $contractor->{'contractor_' . $contractor->index . '_sos'}, array('class' => 'form-control', 'placeholder' => '23123483')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_cn', $contractor->{'contractor_' . $contractor->index . '_cn'}, array('class' => 'form-control', 'placeholder' => '1315547354')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->index . '_sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->index . '_sic', $contractor->{'contractor_' . $contractor->index . '_sic'}, array('class' => 'form-control', 'placeholder' => 'B3B354ASD')) }}
        </div>
    </div>
</div>
