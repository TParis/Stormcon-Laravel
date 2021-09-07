<h3>Inspections</h3>
<div class="form-group row">
    {{ Form::label('inspector_id', 'Inspector', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::select('inspector_id', $inspectors, $project->inspector_id, array('class' => 'text-right form-control')) }}
    </div>
    <div class="col-3"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#inspection-modal">See Schedule</a></div>
</div>
<div class="form-group row">
    {{ Form::label('inspection_cycle', 'Schedule', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::select('inspection_cycle', $inspection_schedules->pluck("Name", "days"), $project->inspection_cycle, array('class' => 'text-right form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('inspection_start', 'Start Date', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::date('inspection_start', $project->inspection_start, array('class' => 'text-right form-control')) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('inspection_cycle', 'Format', array('class' => 'col-3 text-right control-label required-field')) }}
    <div class="col-3">
        {{ Form::select('inspection_format', ['Format A'], [], array('class' => 'text-right form-control')) }}
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
            <td>{{ $inspection->inspection_date }}</td>
            <td>{{ $inspection->status }}</td>
            <td>{{ $inspection->inspector->fullName }}</td>
            <td>{{ $project->inspection_format }}</td>
            <td>{{ $project->inspection_cycle }} days</td>
            <td>{{ $inspection->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal" id="inspection-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered max-width-750">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Block Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function getWeeklySchedule() {
        $.ajax({
            url: "{{ route('inspection::weekly') }}",
            success: function (data) {
                $("#inspection-modal .modal-body").html(data)
            }
        })
    }

    $('#inspection-modal').on('shown.bs.modal', function () {
        getWeeklySchedule();
    });
</script>
