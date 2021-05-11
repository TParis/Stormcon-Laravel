<div class="contractor-{{ $contractor->id }}" id="contractor-{{$contractor->id}}">
    <h3>New Operator</h3>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_role', 'Role', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->id . '_role', $roles, [], array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->id . '_name', $companies, [], array('class' => 'form-control company-select', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_legal_name', "", array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_also_known_as', "", array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_phone', "", array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_fax', "", array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_website', "", array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_address', "", array('class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_city', "", array('class' => 'form-control', 'placeholder' => 'Dallas')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->id . '_state', $states, "", array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_zipcode', 'Zipcode', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_zipcode', "", array('class' => 'form-control', 'placeholder' => '78123')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_federal_tax_id', "", array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_state_tax_id', "", array('class' => 'form-control', 'placeholder' => '1231564897')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_type', "", array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::number('contractor_' . $contractor->id . '_num_of_employees', "", array('class' => 'form-control', 'placeholder' => '5')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_division', "", array('class' => 'form-control', 'placeholder' => 'Residential')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_sos', "", array('class' => 'form-control', 'placeholder' => '23123483')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_cn', "", array('class' => 'form-control', 'placeholder' => '1315547354')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_sic', "", array('class' => 'form-control', 'placeholder' => 'B3B354ASD')) }}
        </div>
    </div>
</div>
