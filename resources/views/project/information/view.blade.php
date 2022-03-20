<h3>Information</h3>
<div class="form-group row">
    {{ Form::label('proj_number', 'Project Number', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('proj_number', $project->proj_number, array('required' => 'required', 'class' => 'form-control', 'readonly' => 'readonly')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('name', 'Project Name', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('name', $project->name, array('required' => 'required', 'class' => 'form-control', 'readonly' => 'readonly')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('latitude', 'Latitude', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('latitude', $project->latitude, array('class' => 'form-control',)) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('longitude', 'Longitude', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('longitude', $project->longitude, array('class' => 'form-control',)) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('mailing_address_street_number', 'Street Number', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('mailing_address_street_number', $project->mailing_address_street_number, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('mailing_address_street_name', 'Street Name', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('mailing_address_street_name', $project->mailing_address_street_name, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('city', 'City', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('city', $project->city, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('state', 'State', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('state', $project->state, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('zipcode', 'Zip Code', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('zipcode', $project->zipcode, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('county_name', 'County', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('county_name', $project->county_name, array('class' => 'form-control', 'list' => 'county_list')) }}
        {{ Form::datalist('county_list', $counties->pluck("name", "name")->toArray()) }}
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
<h3>Project</h3>
<div class="form-group row">
    {{ Form::label('project_company', 'Project Company', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('project_company', $project->project_company, array('class' => 'form-control', 'list' => 'company_list')) }}
        <datalist id="company_list">
            @foreach ($companies as $company)
                <option value="{{$company->name}}" id="{{$company->id}}">{{$company->name}}</option>
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-group row">
    {{ Form::label('cust_proj_number', 'Customer Project #', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('cust_proj_number', $project->cust_proj_number, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('cost_center', 'Cost Center', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('cost_center', $project->cost_center, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Municipal Separate Storm Sewer System</h3>
<div class="form-group row">
    {{ Form::label('local_official_ms4', 'Municipal', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('local_official_ms4', $project->local_official_ms4, array('class' => 'ms4-control form-control', 'list' => 'local_official_ms4_list')) }}
        {{ Form::datalist('local_official_ms4_list', $ms4s->pluck("name", "name")->toArray()) }}
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
    {{ Form::label('local_official_zipcode', 'Zip Code', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('local_official_zipcode', $project->local_official_zipcode, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Dates</h3>
<div class="form-group row">
    {{ Form::label('order_date', 'Order Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('order_date', $project->order_date, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('preparation_date', 'Preparation Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('preparation_date', $project->preparation_date, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('start_date', 'Start Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('start_date', $project->start_date, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('completion_date', 'Completion Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('completion_date', $project->completion_date, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('disturbed_areas_stabilization_date', 'Disturbed Areas Stabilization Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('disturbed_areas_stabilization_date', $project->disturbed_areas_stabilization_date, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('bmp_removal_date', 'BMP Removal Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('bmp_removal_date', $project->bmp_removal_date, array('class' => 'form-control')) }}
    </div>
</div>
<script type="text/javascript">

    $(".tab-content").on("change", ".ms4-control", function(e) {
        el = e.target;
        $.ajax({
            url: "/api/municipals/" + encodeURIComponent(el.value),
            context: el,
            data: {
                'api_token': '{{ Auth::user()->api_token }}',
            },
            success: function(ms4) {

                $("#local_official_address").val(ms4.address);
                $("#local_official_city").val(ms4.city);
                $("#local_official_state").val(ms4.state);
                $("#local_official_zipcode").val(ms4.zipcode);


            },
            error: function() {

                $("#local_official_address").val("");
                $("#local_official_city").val("");
                $("#local_official_state").val("");
                $("#local_official_zipcode").val("");
            }

        })
    })
</script>
