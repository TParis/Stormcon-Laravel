@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route("inspection::schedule") }}">Inspections</a></li>
    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (count($errors))
        <p>Errors: {{ count($errors) }}</p>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Inspections</h1>

    <table id="inspection_schedule" class="table">
        <thead>
        @if (Auth::user()->can('viewInspections'))
        <th>Inspector</th>
        @endif
        <th>Status</th>
        <th class="d-none d-sm-none d-md-table-cell">Ready to NOT</th>
        <th class="d-none d-sm-none d-md-table-cell">NOT'd</th>
        <th class="d-none d-sm-none d-md-table-cell">Project #</th>
        <th>Project Title</th>
        <th>Address</th>
        <th class="d-none d-sm-none d-md-table-cell">Inspection Date</th>
        </thead>
        <tbody>
        @foreach ($inspections as $inspection)
            <tr id="{{ $inspection->id }}">
            @if (Auth::user()->can('viewInspections'))
            <td>{{ $inspection->inspector->fullName }}</td>
            <td>{{ ($inspection->status) ? "Complete" : "Awaiting" }} </td>
            @else
                @if ($inspection->status == 1)
                    <td>Complete</td>
                @else
                    <td><a href="{{ route("inspection::complete", $inspection->id) }}" class="btn btn-primary">Mark Complete</a></td>
                @endif
            @endif
            <td class="d-none d-sm-none d-md-table-cell">{{ ($inspection->project->rdy_to_not) ? "Ready" : "Not Ready" }}</td>
            <td class="d-none d-sm-none d-md-table-cell">{{ ($inspection->project->not_complete()) ? "Ready" : "Not Ready" }}</td>
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->project->proj_number }}</td>
            <td>{{ $inspection->project->name }}</td>
            @if ($inspection->project->latitude && $inspection->project->longitude)
                <td><a href="https://www.google.com/maps/search/?api=1&query={{ $inspection->project->latitude }},{{ $inspection->project->longitude }}" target="_blank">{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}<br \>{{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}</td>
            @else
                <td><a href="https://www.google.com/maps/place/{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}, {{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}" target="_blank">{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}<br \>{{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}</td>
            @endif
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->inspection_date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="modal" id="inspection-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
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

@endsection


@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#inspection_schedule").ready(function() {

                var index = $("#inspection_schedule").find('td:last').index();

                let mydatatable = $("#inspection_schedule").DataTable({
                    order: [[ index, "asc" ]],
                    select: "single"
                });

                //Datasheet button clicks/Modal
                mydatatable.on("select", popup_model);

                function popup_model(e, target, type, indexes) {
                    console.log()
                    var id = mydatatable.row(indexes[0]).id();

                    let url = "/inspection/view/" + id;


                    // Add & Update

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            $(".modal-body").html(data);
                            $(".modal-title").text("Inspection");
                            $("#modal-errors").addClass("d-none");
                            $('#inspection-modal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        },
                        error: function(data) {

                            // 401: Unauthorized
                            if (data.status === "401") {
                                location.href = "/";
                                // All other error codes
                            } else {
                                alert("An error has occured.  See log for details.");
                                console.log('Error:', data);
                            }
                        }
                    });
                };

                //Modal fixer
                $('#inspection_schedule').on('shown.bs.modal', function() {

                });

                $('#inspection_schedule').on('hidden.bs.modal', function() {
                    $("#modal-errors").addClass("d-none");
                    $(".modal-footer").unbind("click");
                });
            });
        };


    </script>
@endsection
