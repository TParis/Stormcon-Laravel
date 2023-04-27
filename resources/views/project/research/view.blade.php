<h3>Researcher</h3>
<div class="form-group row">
    {{ Form::label('researcher', 'Researcher', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('researcher', $researchers, $project->researcher, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('research_completed', 'Completed Date', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::date('research_completed', $project->research_completed, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Research</h3>
<div class="form-group row">
    {{ Form::label('edwards_aquifer', 'Edwards Aquifer', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('edwards_aquifer', ["Inside" => "Inside", "Outside" => "Outside"], $project->edwards_aquifer, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('classified_waters', 'Classified Waters', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('classified_waters', $project->classified_waters, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('receiving_waters', 'Receiving Waters', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('receiving_waters', $project->receiving_waters, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('surrounding_project', 'Water Features Surrounding Projects', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('surrounding_project', $project->surrounding_project, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('within_50ft', 'Within 50ft', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('within_50ft', ["No" => "No", "Yes" => "Yes"], $project->within_50ft, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('huc', '8-Digit HUC #', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('huc', $project->huc, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('impaired_waters', 'Impaired Waters List', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('impaired_waters', $project->impaired_waters, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('indian_lands', 'Indian Lands', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('indian_lands', ["No" => "No", "Yes" => "Yes"], $project->indian_lands, array('class' => 'form-control')) }}
    </div>
</div>

<table class="table table-bordered" id="receiving_waters_table">
    <thead>
    <tr>
        <th scope="col">Name of Receiving</th>
        <th scope="col">Will Receiving Water Be Disturbed?</th>
        <th scope="col">Location of Receiving water</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i <= 6; $i++)
        <tr>
            <td>{{ Form::text("receiving_water_{$i}_name", $project->{"receiving_water_{$i}_name"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
            <td>{{ Form::select("receiving_water_{$i}_is_disturbed", ["" => "", "0" => "No", "1" => "Yes"], $project->{"receiving_water_{$i}_is_disturbed"} ?? '', ['class' => 'form-control']) }}</td>
            <td>{{ Form::text("receiving_water_{$i}_location", $project->{"receiving_water_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    </tbody>
</table>

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
<h3>303 D</h3>
<div class="form-group row">
    {{ Form::label('303d_id', 'Seg ID', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('303d_id', $project->{"303d_id"}, array('class' => 'form-control')) }}
    </div>
</div><!--
<div class="form-group row">
    {{ Form::label('303d_epa', 'Listed EPA', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('303d_epa', ["not " => "No", "" => "Yes"], $project->{"303d_epa"}, array('class' => 'form-control')) }}
    </div>
</div>-->
<div class="form-group row">
    {{ Form::label('303d_tceq', 'Listed TCEQ', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::select('303d_tceq', ["not " => "No", "" => "Yes"], $project->{"303d_tceq"}, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Constituents</h3>
<div class="form-group row">
    {{ Form::label('constituent_1', 'First', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_1', $project->constituent_1, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_1_co_area', 'First CO Area', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_1_co_area', $project->constituent_1_co_area, array('class' => 'form-control')) }}
    </div>
</div>
{{ Form::datalist('water_quality_list', $water_qualities->pluck("category", "category")->toArray()) }}
<div class="form-group row">
    {{ Form::label('constituent_1_tmdl', 'First Category', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_1_tmdl', $project->constituent_1_tmdl, array('class' => 'form-control', 'list' => 'water_quality_list')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_2', 'Second', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_2', $project->constituent_2, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_2_co_area', 'Second CO Area', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_2_co_area', $project->constituent_2_co_area, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_2_tmdl', 'Second Category', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_2_tmdl', $project->constituent_2_tmdl, array('class' => 'form-control', 'list' => 'water_quality_list')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_3', 'Third', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_3', $project->constituent_3, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_3_co_area', 'Third CO Area', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_3_co_area', $project->constituent_3_co_area, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('constituent_3_tmdl', 'Third Category', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('constituent_3_tmdl', $project->constituent_3_tmdl, array('class' => 'form-control', 'list' => 'water_quality_list')) }}
    </div>
</div>
<h3>Erosivity</h3>
<div class="form-group row">
    {{ Form::label('erosivity', 'Erosivity', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::text('erosivity', $project->erosivity, array('class' => 'form-control')) }}
    </div>
</div>

<h3>Sedimentation basins or traps</h3>
<table class="table table-bordered" id="sedimentation_bmps_table">
    <thead>
    <tr>
        <td><b>Are there sedimentation basins or traps?</b> If yes, list the measures taken to reduce the pollutants
            transported off-site by pumping activities.
        </td>
        <th scope="col">{{ Form::label('have_sedimentation_bmps_yes', 'Yes') }} {{ Form::radio('have_sedimentation_bmps', 1, $project->{"have_sedimentation_bmps"} ?? false, ['id'=>'have_sedimentation_bmps_yes']) }}</th>
        <th scope="col">{{ Form::label('have_sedimentation_bmps_no', 'No') }} {{ Form::radio('have_sedimentation_bmps', 0, isset($project->{"have_sedimentation_bmps"}) && !$project->{"have_sedimentation_bmps"}, ['id'=>'have_sedimentation_bmps_no']) }}</th>
    </tr>
    <tr>
        <th scope="col">Prevention Measure</th>
        <th scope="col">Location On-Site</th>
        <th scope="col">Implementation Date</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("sedimentation_{$i}_bmp", $bmps_selection, $project->{"sedimentation_{$i}_bmp"} ?? '', ['class' => 'form-control', 'list' => 'sedimentation_bmps_datalist']) }}</td>
            <td>{{ Form::text("sedimentation_{$i}_location_on_site", $project->{"sedimentation_{$i}_location_on_site"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
            <td>{{ Form::date("sedimentation_{$i}_bmp_implementation_date", $project->{"sedimentation_{$i}_bmp_implementation_date"} ? date('Y-m-d', strtotime($project->{"sedimentation_{$i}_bmp_implementation_date"})) : '', ['class' => 'form-control']) }}</td>
        </tr>
    @endfor
    </tbody>
</table>

<h3>Pollutants</h3>
@for ($i = 1; $i <= 6; $i++)
    <div id="pollutant-{{ $i }}">
        <div class="form-group row">
            {{ Form::label('pollutant_' . $i . '_name', 'Pollutant ' . $i, ['class' => 'text-right col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::select('pollutant_' . $i . '_name', $pollutants, $project->{'pollutant_' . $i . '_name'} ?? '', ['class' => 'form-control', 'list' => 'pollutants_datalist']) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('pollutant_' . $i . '_bmp', 'BMP ' . $i, ['class' => 'text-right col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::select('pollutant_' . $i . '_bmp', $bmps_selection, $project->{'pollutant_' . $i . '_bmp'} ?? '', ['class' => 'form-control', 'list' => 'pollutants_bmps_datalist']) }}
            </div>
        </div>
    </div>
    @if ($i < 6)
        <hr>
    @endif
@endfor

<h3>Pipeline Descriptions</h3>
<div class="form-group row">
    {{ Form::label('pipeline_size', 'Size of pipeline/s', ['class' => 'text-right col-sm-3 col-form-label']) }}
    <div class="col-sm-9">
        {{ Form::number('pipeline_size', $project->pipeline_size ?? '', ['class' => 'form-control', 'min' => 0]) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('pipeline_distance', 'Pipeline Distance', ['class' => 'text-right col-sm-3 col-form-label']) }}
    <div class="col-sm-9">
        {{ Form::number('pipeline_distance', $project->pipeline_distance ?? '', ['class' => 'form-control', 'min' => 0]) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('construction_workspace_width', 'Width of construction workspace', ['class' => 'text-right col-sm-3 col-form-label']) }}
    <div class="col-sm-9">
        {{ Form::number('construction_workspace_width', $project->construction_workspace_width ?? '', ['class' => 'form-control', 'min' => 0]) }}
    </div>
</div>

@include('project.research.bmps_off_site_transfer_of_pollutant_controls')
