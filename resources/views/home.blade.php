@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-9">
            <h2 align="right">Your Projects</h2>
            <table id="yourProjects" class="table">
                <thead>
                <tr>
                    <th>Project Number</th>
                    <th>State</th>
                    <th>Team</th>
                    <th>Assignee</th>
                    <th>Days in Queue</th>
                    <th>Days Active</th>
                </tr>
                </thead>
            </table>
            @if (Auth::user()->hasRole("Owner"))
            <h2 align="right">Active Projects</h2>
                <table id="activeProjects" class="table">
                    <thead>
                    <tr>
                        <th>Project Number</th>
                        <th>State</th>
                        <th>Team</th>
                        <th>Assignee</th>
                        <th>Days in Queue</th>
                        <th>Days Active</th>
                    </tr>
                    </thead>
                </table>
            <h2 align="right">Inspection Phase</h2>
                <table id="inspectionPhase" class="table">
                    <thead>
                    <tr>
                        <th>Project Number</th>
                        <th>State</th>
                        <th>Team</th>
                        <th>Assignee</th>
                        <th>Days in Queue</th>
                        <th>Days Active</th>
                    </tr>
                    </thead>
                </table>
            <h2 align="right">Blocked Projects</h2>
                <table id="blockedProjects" class="table">
                    <thead>
                    <tr>
                        <th>Project Number</th>
                        <th>State</th>
                        <th>Team</th>
                        <th>Assignee</th>
                        <th>Days in Queue</th>
                        <th>Days Active</th>
                    </tr>
                    </thead>
                </table>
            @endif
        </div>
        <div class="col-3">
            <h2 align="right">Quick Actions</h2>
            <div class="container-fluid border">
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
                <hr>
                <a href="#" class="w-100 d-block">Manage Workflows</a>
                <hr>
                <a href="{{ route("ActivityLog") }}" class="w-100 d-block">Activity Log</a>
            </div>
        </div>
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

            $("#yourProjects").DataTable();
            $("#activeProjects").DataTable();
            $("#inspectionPhase").DataTable();
            $("#blockedProjects").DataTable();

        }
    </script>
@endsection
