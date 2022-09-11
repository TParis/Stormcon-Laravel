@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (Auth::user()->hasAnyPermission(['viewConfig', 'viewWorkflows']))
        <div class="col-9">
        @else
        <div class="col-12">
        @endif
            <div class="accordian" id="projectsList">
                <div class="card">
                    <div class="card-header" id="yourProjectsHeading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#yourprojects" aria-expanded="true" aria-controls="yourprojects">
                                Your Projects
                            </button>
                        </h2>
                    </div>
                    <div id="yourprojects" class="collapse show" aria-labelledby="yourProjectsHeading" data-parent="#projectsList">
                        <div class="card-body">
                            <table id="yourProjects" class="table">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>State</th>
                                    <th>Team</th>
                                    <th>Assignee</th>
                                    <th>Days Active</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($your_projects as $project)
                                    <tr data-workflow="{{ $project->step()->days }}" data-in-queue="{{ $project->hours_in_queue }}">
                                        <td><a href="{{ route("project::view", $project->project->id) }}">{{ $project->project->name }}</a></td>
                                        <td>{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }}</td>
                                        <td>{{ (is_array($project->step()->role)) ? implode(", ", $project->step()->role) : $project->step()->role }}</td>
                                        <td>{{ ($project->step()->user_id) ? $project->step()->user_id : "None" }}</td>
                                        <td>{{ $project->days_active }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="teamProjectsHeading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#teamprojects" aria-expanded="true" aria-controls="teamprojects">
                                Team Projects
                            </button>
                        </h2>
                    </div>
                    <div id="teamprojects" class="collapse" aria-labelledby="teamProjectsHeading" data-parent="#projectsList">
                        <div class="card-body">
                            <table id="yourTeamProjects" class="table">
                                <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>State</th>
                                    <th>Team</th>
                                    <th>Assignee</th>
                                    <th>Days Active</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($your_team_projects as $project)
                                    <tr data-workflow="{{ $project->step()->days }}" data-in-queue="{{ $project->hours_in_queue }}">
                                        <td><a href="{{ route("project::view", $project->project->id) }}">{{ $project->project->name }}</a></td>
                                        <td>{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }}</td>
                                        <td>{{ (is_array($project->step()->role)) ? implode(", ", $project->step()->role) : $project->step()->role }}</td>
                                        <td>{{ ($project->step()->user_id) ? $project->step()->user_id : "None" }}</td>
                                        <td>{{ $project->days_active }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->hasRole("Owner"))
                <div class="card">
                    <div class="card-header" id="swpppProjectsHeading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#swpppphase" aria-expanded="true" aria-controls="swpppphase">
                                SWPPP Phase
                            </button>
                        </h2>
                    </div>
                    <div id="swpppphase" class="collapse" aria-labelledby="swpppProjectsHeading" data-parent="#projectsList">
                        <div class="card-body">
                            <table id="activeProjects" class="table">
                                <thead>
                                <tr>
                                    <th>Project Number</th>
                                    <th>State</th>
                                    <th>Team</th>
                                    <th>Assignee</th>
                                    <th>Days Active</th>
                                </tr>
                                </thead>
                                @foreach($active_projects as $project)
                                    <tr data-workflow="{{ $project->step()->days }}" data-in-queue="{{ $project->hours_in_queue }}">
                                        <td><a href="{{ route("project::view", $project->project->id) }}">{{ $project->project->name }}</a></td>
                                        <td>{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }}</td>
                                        <td>{{ (is_array($project->step()->role)) ? implode(", ", $project->step()->role) : $project->step()->role }}</td>
                                        <td>{{ ($project->step()->user_id) ? $project->step()->user_id : "None" }}</td>
                                        <td>{{ $project->days_active }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="inspProjectsHeading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#inspphase" aria-expanded="true" aria-controls="inspphase">
                                Inspection Phase
                            </button>
                        </h2>
                    </div>
                    <div id="inspphase" class="collapse" aria-labelledby="inspProjectsHeading" data-parent="#projectsList">
                        <div class="card-body">
                            <table id="inspectionPhase" class="table">
                                <thead>
                                <tr>
                                    <th>Project Number</th>
                                    <th>State</th>
                                    <th>Team</th>
                                    <th>Assignee</th>
                                    <th>Days Active</th>
                                </tr>
                                @foreach($inspection_projects as $project)
                                    <tr data-workflow="{{ $project->step()->days }}" data-in-queue="{{ $project->hours_in_queue }}">
                                        <td><a href="{{ route("project::view", $project->project->id) }}">{{ $project->project->name }}</a></td>
                                        <td>{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }}</td>
                                        <td>{{ (is_array($project->step()->role)) ? implode(", ", $project->step()->role) : $project->step()->role }}</td>
                                        <td>{{ ($project->step()->user_id) ? $project->step()->user_id : "None" }}</td>
                                        <td>{{ $project->days_active }}</td>
                                    </tr>
                                @endforeach
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                    <div class="card">
                        <div class="card-header" id="blockProjectsHeading">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#blockedProjs" aria-expanded="true" aria-controls="blockedProjs">
                                    Blocked Projects
                                </button>
                            </h2>
                        </div>
                        <div id="blockedProjs" class="collapse" aria-labelledby="blockProjectsHeading" data-parent="#projectsList">
                            <div class="card-body">
                                <table id="blockedProjects" class="table">
                                    <thead>
                                    <tr>
                                        <th>Project Number</th>
                                        <th>State</th>
                                        <th>Team</th>
                                        <th>Assignee</th>
                                        <th>Days Active</th>
                                    </tr>
                                    </thead>
                                    @foreach($blocked_projects as $project)
                                        <tr data-workflow="{{ $project->step()->days }}"  data-in-queue="{{ $project->hours_in_queue }}" data-toggle="tooltip" data-placement="bottom" title="{{ $project->blocker }}">
                                            <td><a href="{{ route("project::view", $project->project->id) }}">{{ $project->project->name }}</a></td>
                                            <td>{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }}</td>
                                            <td>{{ (is_array($project->step()->role)) ? implode(", ", $project->step()->role) : $project->step()->role }}</td>
                                            <td>{{ ($project->step()->user_id) ? $project->step()->user_id : "None" }}</td>
                                            <td>{{ $project->days_active }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                <br />
                <h2>Team Projects</h2>
                    @foreach($teams as $name => $team_project)
                        @php
                          $htmlname = preg_replace("/[^A-Za-z0-9]/", '', $name);
                        @endphp
                        <div class="card">
                            <div class="card-header" id="{{ $htmlname }}TeamProjectsHeading">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#{{ $htmlname }}TeamProjects" aria-expanded="true" aria-controls="{{ $htmlname }}TeamProjects">
                                        Team {{ $name }} Projects
                                    </button>
                                </h2>
                            </div>
                            <div id="{{ $htmlname }}TeamProjects" class="collapse" aria-labelledby="{{ $htmlname }}TeamProjectsHeading" data-parent="#projectsList">
                                <div class="card-body">
                                    <table id="blockedProjects" class="table">
                                        <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>State</th>
                                            <th>Team</th>
                                            <th>Assignee</th>
                                            <th>Days Active</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($team_project as $project)
                                            <tr data-workflow="{{ $project->step()->days }}" data-in-queue="{{ $project->hours_in_queue }}">
                                                <td><a href="{{ route("project::view", $project->project->id) }}">{{ $project->project->name }}</a></td>
                                                <td>{{ App\Http\Controllers\ProjectController::getStatusCleartext($project->status) }}</td>
                                                <td>{{ (is_array($project->step()->role)) ? implode(", ", $project->step()->role) : $project->step()->role }}</td>
                                                <td>{{ ($project->step()->user_id) ? $project->step()->user_id : "None" }}</td>
                                                <td>{{ $project->days_active }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        @if (Auth::user()->hasAnyPermission(['viewConfig', 'viewWorkflows']))
        <div class="col-3">
            <h2 align="right">Quick Actions</h2>
            <div class="container-fluid border">
                @if (Auth::user()->can('viewConfig'))
                <a href="{{ route("company::add") }}" class="w-100 d-block">Create Company</a>
                <a href="{{ route("county::add") }}" class="w-100 d-block">Create County</a>
                <a href="{{ route("municipal::add") }}" class="w-100 d-block">Create Municipal</a>
                <a href="#" class="w-100 d-block">Create Project</a>
                <hr>
                <a href="{{ route("bmps::index") }}" class="w-100 d-block">Create BMP</a>
                <a href="{{ route("species::add") }}" class="w-100 d-block">Create Endangered Species</a>
                <a href="{{ route("schedule::index") }}" class="w-100 d-block">Create Inspection Schedule</a>
                <a href="{{ route("responsibilities::index") }}" class="w-100 d-block">Create Responsibility</a>
                <a href="{{ route("soils::index") }}" class="w-100 d-block">Create Soil</a>
                <a href="{{ route("waterquality::index") }}" class="w-100 d-block">Create Water Quality</a>
                @endif
                @if (Auth::user()->hasAnyPermission(['viewConfig', 'viewWorkflows']))
                <hr>
                @endif
                @if (Auth::user()->can('viewWorkflows'))
                <a href="{{ route("workflow_template::index") }}" class="w-100 d-block">Manage Workflows</a>
                @endif
                @if (Auth::user()->hasRole(['Sr Admin', 'Owner']))
                <hr>
                <a href="{{ route("ActivityLog") }}" class="w-100 d-block">Activity Log</a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#yourProjects").DataTable({
                "createdRow": function( row, data, dataIndex){
                    if (data[4] > $(row).data("workflow")) {
                        $(row).addClass("redRow");
                    }
                }
            });
            $("#yourTeamProjects").DataTable({
                "createdRow": function( row, data, dataIndex){
                    if (data[4] > $(row).data("workflow")) {
                        $(row).addClass("redRow");
                    }
                }
            });
            $("#activeProjects").DataTable({
                "createdRow": function( row, data, dataIndex){
                    if (data[4] > $(row).data("workflow")) {
                        $(row).addClass("redRow");
                    }
                }
            });
            $("#inspectionPhase").DataTable({
                "createdRow": function( row, data, dataIndex){
                    if ($(row).data("in-queue") > $(row).data("workflow")) {
                        $(row).addClass("redRow");
                    }
                }
            });
            $("#blockedProjects").DataTable({
                "createdRow": function( row, data, dataIndex){
                    if (data[4] > $(row).data("workflow")) {
                        $(row).addClass("redRow");
                    }
                }
            });

        }
    </script>
@endsection
