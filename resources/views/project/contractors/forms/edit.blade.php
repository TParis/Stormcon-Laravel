<div class="contractor-{{ $contractor->id }}" id="contractor-{{$contractor->id}}">
    @if ($contractor->role)
        <h3>{{ $contractor->role }}</h3>
    @else
        <h3>New Contractor</h3>
    @endif
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_role', 'Role', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->id . '_role', $roles, $contractor->role, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->id . '_name', $companies, $contractor->name, array('class' => 'form-control company-select', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_legal_name', $contractor->legal_name, array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_also_known_as', $contractor->also_known_as, array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_phone', $contractor->phone, array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_fax', $contractor->fax, array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_website', $contractor->website, array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_address', $contractor->address, array('class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_city', $contractor->city, array('class' => 'form-control', 'placeholder' => 'Dallas')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('contractor_' . $contractor->id . '_state', $states, $contractor->state, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_zipcode', 'Zipcode', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_zipcode', $contractor->zipcode, array('class' => 'form-control', 'placeholder' => '78123')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_federal_tax_id', $contractor->federal_tax_id, array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_state_tax_id', $contractor->state_tax_id, array('class' => 'form-control', 'placeholder' => '1231564897')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_type', $contractor->type, array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::number('contractor_' . $contractor->id . '_num_of_employees', $contractor->num_of_employees, array('class' => 'form-control', 'placeholder' => '5')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_division', $contractor->division, array('class' => 'form-control', 'placeholder' => 'Residential')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_sos', $contractor->sos, array('class' => 'form-control', 'placeholder' => '23123483')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_cn', $contractor->cn, array('class' => 'form-control', 'placeholder' => '1315547354')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('contractor_' . $contractor->id . '_sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('contractor_' . $contractor->id . '_sic', $contractor->sic, array('class' => 'form-control', 'placeholder' => 'B3B354ASD')) }}
        </div>
    </div>
</div>
