<!--
<h3>Sedimentation Pond</h3>
<div class="form-group row">
    {{ Form::label('sedi_pond', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('sedi_pond', $project->sedi_pond, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('sedi_pond_design', 'Design', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('sedi_pond_design', $project->sedi_pond_design, array('class' => 'form-control')) }}
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
        {{ Form::textarea('sedi_pond_maintenance', $project->sedi_pond_maintenance, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('sedi_pond_feasibility', 'Feasibility', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('sedi_pond_feasibility', $project->sedi_pond_feasibility, array('class' => 'form-control')) }}
    </div>
</div>-->
<h3>Stabilization Plan</h3>
<div class="form-group row">
    {{ Form::label('stabilization_description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('stabilization_description', $project->stabilization_description, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('stabilization_dates', 'Dates', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('stabilization_dates', $project->stabilization_dates, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('stabilization_schedule', 'Schedule', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('stabilization_schedule', $project->stabilization_schedule, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('stabilization_responsibility', 'Responsibility', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('stabilization_responsibility', $project->stabilization_responsibility, array('class' => 'form-control')) }}
    </div>
</div>
