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
        {{ Form::select('classified_waters', ["Yes" => "Yes", "No" => "No"], $project->classified_waters, array('class' => 'form-control')) }}
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
