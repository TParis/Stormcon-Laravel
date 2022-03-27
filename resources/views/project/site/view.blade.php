<h3>Construction Site Description</h3>
<div class="form-group row">
    {{ Form::label('description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('description', $project->description, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('acres', 'Total Acres', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
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
    {{ Form::label('existing_system', 'Existing Stormdrain System', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('existing_system', $project->existing_system, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('larger_plan', 'Part of a Larger Plan', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('larger_plan', ["No" => "No", "Yes" => "Yes"], $project->larger_plan, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Soils</h3>
@for ($i = 1; $i <= 8; $i++)
    <div id="soil-{{ $i }}">
        <div class="form-group row">
            {{ Form::label('soil_' . $i . '_type', 'Soil ' . $i . ' Type', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
            <div class="col-sm-9">
                {{ Form::text('soil_' . $i . '_type', $project->{"soil_" . $i . "_type"}, array('class' => 'soil-control form-control', 'list' => 'soils_datalist')) }}
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
    @if ($i < 8)
    <hr>
    @endif
@endfor
{{ Form::datalist('soils_datalist', $soils->pluck("name", "name")->toArray()) }}
<h3>Sendiment Pond</h3>
<div class="form-group row">
    {{ Form::label('sedi_pond', 'Sedimentation Pond', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('sedi_pond', ['Yes' => 'Yes', 'No' => 'No'], $project->sedi_pond, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('sedi_pond_design', 'Design', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('sedi_pond_design', $project->sedi_pond_design, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('sedi_pond_construction', 'Construction', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('sedi_pond_construction', $project->sedi_pond_construction, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('sedi_pond_maintenance', 'Maintenance', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('sedi_pond_maintenance', $project->sedi_pond_maintenance, array('class' => 'form-control')) }}
    </div>
</div>
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
<script type="text/javascript">

    $(".tab-content").on("change", ".soil-control", function(e) {
        el = e.target;
        $.ajax({
            url: "/api/soils/" + encodeURIComponent(el.value),
            context: el,
            data: {
                'api_token': '{{ Auth::user()->api_token }}',
            },
            success: function(soil) {

                let prefix = $(this).attr("id").substr(0, $(this).attr("id").lastIndexOf("_")+1);

                $("#" + prefix + "hsg").val(soil.group);
                $("#" + prefix + "k_factor").val(soil.k);


            },
            error: function() {

                let prefix = $(this).attr("id").substr(0, $(this).attr("id").lastIndexOf("_")+1);

                $("#" + prefix + "hsg").val("");
                $("#" + prefix + "k_factor").val("");
            }

        })
    })
</script>
