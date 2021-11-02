<div class="provider-{{ $iter }}" id="provider-{{$iter}}">
    <h3>{{ $provider->{'provider_' . $provider->index . '_role'} }}</h3>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_role', 'Role', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('provider_' . $provider->index . '_role', $roles, $provider->{'provider_' . $provider->index . '_role'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_name', 'Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('provider_' . $provider->index . '_name', $companies, $provider->{'provider_' . $provider->index . '_name'}, array('class' => 'form-control company-select', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_legal_name', 'Legal Name', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_legal_name', $provider->{'provider_' . $provider->index . '_legal_name'}, array('class' => 'form-control', 'placeholder' => 'Gas R Us LLC')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_also_known_as', 'Also Known As', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_also_known_as', $provider->{'provider_' . $provider->index . '_also_known_as'}, array('class' => 'form-control', 'placeholder' => 'Gas R Us')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_phone', 'Phone Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_phone', $provider->{'provider_' . $provider->index . '_phone'}, array('class' => 'form-control', 'placeholder' => '123-456-7890')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_fax', 'Fax Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_fax', $provider->{'provider_' . $provider->index . '_fax'}, array('class' => 'form-control', 'placeholder' => '123-456-7891')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_website', 'Website', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_website', $provider->{'provider_' . $provider->index . '_website'}, array('class' => 'form-control', 'placeholder' => 'https://www.website.com/')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_address', 'Address', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_address', $provider->{'provider_' . $provider->index . '_address'}, array('class' => 'form-control', 'placeholder' => '123 Main St East #211')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_city', 'City', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_city', $provider->{'provider_' . $provider->index . '_city'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_state', 'State', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::select('provider_' . $provider->index . '_state', $states, $provider->{'provider_' . $provider->index . '_state'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_zipcode', 'Zipcode', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_zipcode', $provider->{'provider_' . $provider->index . '_zipcode'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_federal_tax_id', 'Federal Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_federal_tax_id', $provider->{'provider_' . $provider->index . '_federal_tax_id'}, array('class' => 'form-control', 'placeholder' => '25-1354867')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_state_tax_id', 'State Tax ID', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_state_tax_id', $provider->{'provider_' . $provider->index . '_state_tax_id'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_type', 'Type of Company', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_type', $provider->{'provider_' . $provider->index . '_type'}, array('class' => 'form-control', 'placeholder' => 'Limited Liability Corporation')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_num_of_employees', 'Number of Employees', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::number('provider_' . $provider->index . '_num_of_employees', $provider->{'provider_' . $provider->index . '_num_of_employees'}, array('class' => 'form-control', 'placeholder' => '5')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_division', 'Division', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_division', $provider->{'provider_' . $provider->index . '_division'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_sos', 'SOS Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_sos', $provider->{'provider_' . $provider->index . '_sos'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_cn', 'CN Number', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_cn', $provider->{'provider_' . $provider->index . '_cn'}, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('provider_' . $provider->index . '_sic', 'SIC Code', array('class' => 'col-4 text-right control-label required-field')) }}
        <div class="col-8">
            {{ Form::text('provider_' . $provider->index . '_sic', $provider->{'provider_' . $provider->index . '_sic'}, array('class' => 'form-control')) }}
        </div>
    </div>
</div>
