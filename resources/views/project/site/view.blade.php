<h3>Construction Site Description</h3>
<div class="form-group row">
    {{ Form::label('description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('description', $project->description, array('class' => 'form-control')) }}
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

<table class="table table-bordered" id="construction_site_details_table">
<thead>
    <tr>
        <th scope="col">Material Storage</th>
        <th scope="col">Material (s)/Equipment</th>
        <th scope="col">Acreage</th>
        <th scope="col">Location</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Off-site</td>
        <td>{{ Form::text('material_storage_off_site_materials_or_equipment', $project->material_storage_off_site_materials_or_equipment, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        <td>{{ Form::number('material_storage_off_site_acreage', $project->material_storage_off_site_acreage, ['class' => 'form-control acreage-value', 'step' => '0.01', 'min' => 0]) }}</td>
        <td>{{ Form::text('material_storage_off_site_location', $project->material_storage_off_site_location, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
    </tr>
    <tr>
        <td>On-site</td>
        <td>{{ Form::text('material_storage_on_site_materials_or_equipment', $project->material_storage_on_site_materials_or_equipment, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        <td>{{ Form::number('material_storage_on_site_acreage', $project->material_storage_on_site_acreage, ['class' => 'form-control acreage-value', 'step' => '0.01', 'min' => 0]) }}</td>
        <td>{{ Form::text('material_storage_on_site_location', $project->material_storage_on_site_location, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
    </tr>
    <tr>
        <td>Overburden/Stockpiles of Dirt</td>
        <td>{{ Form::text('material_storage_overburden_materials_or_equipment', $project->material_storage_overburden_materials_or_equipment, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        <td>{{ Form::number('material_storage_overburden_acreage', $project->material_storage_overburden_acreage, ['class' => 'form-control acreage-value', 'step' => '0.01', 'min' => 0]) }}</td>
        <td>{{ Form::text('material_storage_overburden_location', $project->material_storage_overburden_location, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
    </tr>
    <tr>
        <td>Borrow Areas</td>
        <td>{{ Form::text('material_storage_borrow_areas_materials_or_equipment', $project->material_storage_borrow_areas_materials_or_equipment, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        <td>{{ Form::number('material_storage_borrow_areas_acreage', $project->material_storage_borrow_areas_acreage, ['class' => 'form-control acreage-value', 'step' => '0.01', 'min' => 0]) }}</td>
        <td>{{ Form::text('material_storage_borrow_areas_location', $project->material_storage_borrow_areas_location, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
    </tr>
    <tr>
        <td>Other areas used as part of the project</td>
        <td>{{ Form::text('material_storage_other_areas_materials_or_equipment', $project->material_storage_other_areas_materials_or_equipment, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        <td>{{ Form::number('material_storage_other_areas_acreage', $project->material_storage_other_areas_acreage, ['class' => 'form-control acreage-value', 'step' => '0.01', 'min' => 0]) }}</td>
        <td>{{ Form::text('material_storage_other_areas_location', $project->material_storage_other_areas_location, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
    </tr>
    <tr>
        <td>Construction Support Activities</td>
        <td>{{ Form::text('material_storage_activities_materials_or_equipment', $project->material_storage_activities_materials_or_equipment, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        <td>{{ Form::number('material_storage_activities_acreage', $project->material_storage_activities_acreage, ['class' => 'form-control acreage-value', 'step' => '0.01', 'min' => 0]) }}</td>
        <td>{{ Form::text('material_storage_activities_location', $project->material_storage_activities_location, ['class' => 'form-control', 'maxlength' => 255]) }}</td>
    </tr>
    <tr>
        <th scope="row">Total acreage of project property:</th>
        <td>{{ Form::number('acres', $project->acres, ['class' => 'form-control', 'step' => '0.01', 'min' => 0]) }}</td>
        <th scope="row">Total acreage of disturbed soil:</th>
        <td>{{ Form::number('acres_disturbed', $project->acres_disturbed, ['class' => 'form-control', 'step' => '0.01', 'min' => 0, 'readonly' => 'readonly']) }}</td>
    </tr>
    </tbody>
</table>

<h3>Critical Areas</h3>
<div class="form-group row">
    {{ Form::label('critical_areas', 'Critical Areas', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('critical_areas', $project->critical_areas, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Detention Pond</h3>
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
    });

    $('#construction_site_details_table td input.acreage-value, #construction_site_details_table td input[name="acres"]').on('change keyup', function () {
        let number = $(this).val();

        if (Math.floor(number) !== number && number.split('.')[1] !== undefined && number.split('.')[1].length > 2) {
            $(this).val(parseFloat(number).toFixed(2));
        }

        if ($(this).attr('name') !== 'acres') {
            let acres_disturbed = 0;

            $('#construction_site_details_table td input.acreage-value').each(function () {
                if ($(this).val()) {
                    acres_disturbed += parseFloat($(this).val());
                }
            });

            $('#construction_site_details_table td input[name="acres_disturbed"]').val(acres_disturbed.toFixed(2));
        }
    });
</script>
