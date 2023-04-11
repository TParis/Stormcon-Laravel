@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item active" aria-current="page">Pollutants</li>
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
    <div class="container-fixed">
        <button class="btn btn-info add-btn" data-action="add"><i class="glyphicon glyphicon-plus"></i> Add New
            Pollutant
        </button>
        <table id="pollutants" class="table table-sortable table-bordered table-striped display">
            <thead>
            <tr>
                <th>Name</th>
                <th>Source</th>
                <th>Material</th>
                <th>Average</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pollutants as $pollutant)
                @php
                    /**
                    * @var \App\Models\Pollutant $pollutant
                    */
                @endphp
                <tr id="{{ $pollutant->id }}">
                    <td>{{ $pollutant->{$pollutant::COLUMNS['name']} }}</td>
                    <td>{{ $pollutant->{$pollutant::COLUMNS['source']} }}</td>
                    <td>{{ $pollutant->{$pollutant::COLUMNS['material']} }}</td>
                    <td>{{ $pollutant->{$pollutant::COLUMNS['average']} }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <button class="btn btn-info add-btn" data-action="add"><i class="glyphicon glyphicon-plus"></i> Add New Pollutant
    </button>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit_pollutant">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal title</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div id="modal-errors" class="modal-body hide">
                    <div class="alert alert-danger">
                    </div>
                </div>
                <div id="modal-content" class="modal-body">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@section("scripts")
    <script type="text/javascript">
        window.onload = function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#pollutants").ready(function () {
                let mydatatable = $("#pollutants").DataTable({
                    select: "single"
                });

                //Datasheet button clicks/Modal
                mydatatable.on("select", popup_model);
                $(".add-btn").on("click", popup_model);

                function popup_model(e, target, type, indexes) {
                    let action;

                    if (e.namespace == "dt") {
                        action = "edit";
                    } else {
                        action = $(this).data("action");
                    }

                    let url = "/pollutants/" + action;

                    if (action == "edit") {
                        url += "/" + mydatatable.row(indexes[0]).id();
                    }

                    // Add & Update

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (data) {
                            $("#modal-content").html(data);
                            $(".modal-title").text(action.toUpperCase() + " Pollutant");
                            $("#modal-errors").addClass("d-none");
                            $('#edit_pollutant').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        },
                        error: function (data) {
                            if (data.status === "401") {
                                location.href = "/";
                            } else {
                                alert("An error has occurred.  See log for details.");
                                console.log('Error:', data);
                            }
                        }
                    });
                };

                //Modal fixer
                $('#edit_pollutant').on('shown.bs.modal', function () {
                    $('#myInput').focus();
                });

                $('#edit_pollutant').on('hidden.bs.modal', function () {
                    $("#modal-errors").addClass("d-none");
                    $(".modal-footer").unbind("click");
                });
            });
        };

        function deletePollutant(id, name) {
            if (confirm("Are you sure you want to delete " + name)) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/pollutants/delete/' + id,
                    type: 'DELETE',
                    success: function (result) {
                        window.location = "/pollutants";
                    }
                });
            }
        }

    </script>
@endsection
