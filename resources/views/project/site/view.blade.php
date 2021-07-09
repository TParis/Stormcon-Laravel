<h3>Information</h3>
<div class="form-group row">
    {{ Form::label('description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('description', $project->description, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('acres', 'Acres', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('acres', $project->acres, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('acres_disturbed', 'Acres Disturbed', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('acres_disturbed', $project->acres_disturbed, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('existing_system', 'Existing System', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('existing_system', $project->existing_system, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('larger_plan', 'Larger Plan', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('larger_plan', ["No" => "No", "Yes" => "Yes"], $project->larger_plan, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Soils</h3>
@for ($i = 1; $i <= 7; $i++)
    <div id="soil-{{ $i }}">
        <div class="form-group row">
            {{ Form::label('soil_' . $i . '_type', 'Soil ' . $i . ' Type', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
            <div class="col-sm-9">
                {{ Form::select('soil_' . $i . '_type', $soils->pluck("name"), $project->{"soil_" . $i . "_type"}, array('class' => 'form-control', 'placeholder' => 'Please select')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('soil_' . $i . '_hsg', 'Soil ' . $i . ' HSG', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
            <div class="col-sm-9">
                {{ Form::text('soil_' . $i . '_hsg', $project->{"soil_" . $i . "_hsg"}, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('soil_' . $i . '_k_factor', 'Soil ' . $i . ' K Factor', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
            <div class="col-sm-9">
                {{ Form::text('soil_' . $i . '_k_factor', $project->{"soil_" . $i . "_k_factor"}, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('soil_' . $i . '_area', 'Soil ' . $i . ' Area', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
            <div class="col-sm-9">
                {{ Form::text('soil_' . $i . '_area', $project->{"soil_" . $i . "_area"}, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    @if ($i < 7)
    <hr>
    @endif
@endfor
<h3>Erosivity</h3>
<div class="form-group row">
    {{ Form::label('erosivity', 'Erosivity', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('erosivity', $project->erosivity, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Coefficient</h3>
<div class="form-group row">
    {{ Form::label('pre_construction_coefficient', 'Pre Construction', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('pre_construction_coefficient', $project->pre_construction_coefficient, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('post_construction_coefficient', 'Post Construction', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('post_construction_coefficient', $project->post_construction_coefficient, array('class' => 'form-control')) }}
    </div>
</div>
