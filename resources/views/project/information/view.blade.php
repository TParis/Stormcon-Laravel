<h3>Information</h3>
<div class="form-group row">
    {{ Form::label('name', 'Project Name', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('name', $project->name, array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Project Name')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('latitude', 'Latitude', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('latitude', $project->latitude, array('class' => 'form-control', 'placeholder' => '00.000')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('longitude', 'Longitude', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('longitude', $project->longitude, array('class' => 'form-control', 'placeholder' => '00.000')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('mailing_address_street_number', 'Street Number', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('mailing_address_street_number', $project->mailing_address_street_number, array('class' => 'form-control', 'placeholder' => 'Dallas')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('mailing_address_street_name', 'Street Name', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('mailing_address_street_name', $project->mailing_address_street_name, array('class' => 'form-control', 'placeholder' => 'Dallas')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('city', 'City', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('city', $project->city, array('class' => 'form-control', 'placeholder' => 'Dallas')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('state', 'State', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('state', $project->state, array('class' => 'form-control', 'placeholder' => 'Texas')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('zipcode', 'Zipcode', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('zipcode', $project->zipcode, array('class' => 'form-control', 'placeholder' => '78123')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('county_id', 'County', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('county_id', $counties,  $project->county_id, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('directions', 'Directions', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('directions', $project->directions, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('nearest_city', 'Nearest City', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('nearest_city', $project->nearest_city, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Municipal Separate Storm Sewer System</h3>
<div class="form-group row">
    {{ Form::label('local_official_ms4', 'Municipal', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('local_official_ms4', $ms4s->pluck("name", "name"), $project->local_official_ms4, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('local_official_address', 'Address', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('local_official_address', $project->local_official_address, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('local_official_city', 'City', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('local_official_city', $project->local_official_city, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('local_official_state', 'State', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('local_official_state', $project->local_official_state, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('local_official_zipcode', 'Zipcode', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('local_official_zipcode', $project->local_official_zipcode, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Engineer's Information</h3>
<div class="form-group row">
    {{ Form::label('engineer_name', 'Company', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('engineer_name', $companies->pluck("name"), $project->engineer_name, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_street', 'Address', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_street', $project->engineer_street, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_city', 'City', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_city', $project->engineer_city, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_state', 'State', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_state', $project->engineer_state, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_zipcode', 'Zipcode', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_zipcode', $project->engineer_zipcode, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_contact', 'Contact', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_contact', $project->engineer_contact, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_phone', 'Phone', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_phone', $project->engineer_phone, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_email', 'Email', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_email', $project->engineer_email, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('engineer_fax', 'Fax', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('engineer_fax', $project->engineer_fax, array('class' => 'form-control')) }}
    </div>
</div>
