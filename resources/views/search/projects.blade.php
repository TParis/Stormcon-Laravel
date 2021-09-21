<div class="container-fluid border-dark table-bordered border-info mb-1">
    <div class="row">
        <div class="col-1"><strong>Type</strong></div>
        <div class="col-2"><strong>Name</strong></div>
        <div class="col-2"><strong>Status</strong></div>
        <div class="col-2"><strong>Step</strong></div>
        <div class="col-2"><strong>Location</strong></div>
        <div class="col-3"><strong>Updated</strong></div>
    </div>
    <div class="row">
        <div class="col-1">Project</div>
        <div class="col-2"><a href="{{ route("project::view", $result["id"]) }}">{{ $result["name"] }}</a></div>
        @php
            $project = App\Models\Project::find($result["id"]);
        @endphp
        <div class="col-2">{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->workflow->status) }}</div>
        <div class="col-2">{{ $project->workflow->step()->name }}</div>
        <div class="col-2">Location:{{ $result["city"] }}, {{ $result["state"] }}</div>
        <div class="col-3">{{ $result["updated_at"] }}</div>
    </div>
</div>
