<h3>Inspections</h3>
<div class="form-group row">
    {{ Form::label('inspector_id', 'Inspector', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::select('inspector_id', $inspectors, $project->inspector_id, array('class' => 'text-right form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('inspection_cycle', 'Schedule', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::select('inspection_cycle', $inspection_schedules->pluck("Name", "days"), $project->inspection_cycle, array('class' => 'text-right form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('inspection_cycle', 'Format', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::select('inspection_format', [], [], array('class' => 'text-right form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('rdy_to_noi', 'Ready to NOI', array('class' => 'col-3 text-right control-label')) }}
    <div class="col-9">
        {{ Form::checkbox('rdy_to_noi', 'true', $project->rdy_to_noi, array('class' => 'control-label', 'style' => 'margin-top: 7px;')) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('rdy_to_not', 'Ready to NOT', array('class' => 'col-3 text-right control-label')) }}
    <div class="col-9">
        {{ Form::checkbox('rdy_to_not', 'true', $project->rdy_to_not, array('class' => 'control-label', 'style' => 'margin-top: 7px;')) }}
    </div>
</div>
<hr>
<h2>Inspections</h2>
<table class="table table-bordered table-primary">
    <thead>
    <th>Date</th>
    <th>Status</th>
    <th>Inspector</th>
    <th>Format</th>
    <th>Cycle</th>
    <th>Last Updated</th>
    </thead>
    <tbody>
        @foreach ($project->inspections as $inspection)
        <tr>
            <td>{{ $inspection->date }}</td>
            <td>{{ $inspection->status }}</td>
            <td>{{ $inspection->inspector->fullName }}</td>
            <td>{{ $project->inspection_format }}</td>
            <td>{{ $inspection->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
