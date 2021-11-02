@component('mail::message')
# Land Development NOI Report

This is the report for the active Land Development projects that are missing NOI signers.

@component('mail::table')
| Project   | Status    | Link  |
| :---      | :---:     | ---:  |
@foreach ($projects as $project)
| {{ $project->name }} | {{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }} | [Click here]({{ route("project::view", $project->id) }})
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
