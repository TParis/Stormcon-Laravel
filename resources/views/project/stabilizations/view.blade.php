<h3>Critical Areas</h3>
<div class="form-group row">
    {{ Form::label('critical_areas', 'Critical Areas', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('critical_areas', $project->critical_areas, array('class' => 'form-control')) }}
    </div>
</div>
<h3>Sedimentation Pond</h3>
<div class="form-group row">
    {{ Form::label('description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('description', $project->description, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('description', $project->description, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('acres', 'Acres', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('acres', $project->acres, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('acres_disturbed', 'Acres Disturbed', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('acres_disturbed', $project->acres_disturbed, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('description', 'Description', array('class' => 'text-right col-sm-3 col-form-label required-field')) }}
    <div class="col-sm-9">
        {{ Form::textarea('description', $project->description, array('class' => 'form-control')) }}
    </div>
</div>
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
