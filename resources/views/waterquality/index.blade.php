@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item">Configuration</li>
        <li class="breadcrumb-item active" aria-current="page">Water Qualities</li>
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
        <button class="btn btn-info add-btn" data-action="add"><i class="glyphicon glyphicon-plus"></i> Add New Water Quality</button>
		<table id="waterqualities" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
					<th>Category</th>
                    <th>Description</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($qualities as $quality)
				<tr id="{{ $quality->id }}">
					<td>{{ $quality->category }}</td>
					<td>{{ \Illuminate\Support\Str::limit($quality->description, 120, $end='...') }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<button class="btn btn-info add-btn" data-action="add"><i class="glyphicon glyphicon-plus"></i> Add New Water Quality</button>
    <div class="modal fade" tabindex="-1" role="dialog" id="editwaterqualities">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal title</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<script language="javascript" type="text/javascript">
    window.onload = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#waterqualities").ready(function() {
            let mydatatable = $("#waterqualities").DataTable({
                select: "single"
            });

            //Datasheet button clicks/Modal
            mydatatable.on("select", popup_model);
            $(".add-btn").on("click", popup_model);

            function popup_model(e, target, type, indexes) {
                console.log()
                if (e.namespace == "dt") {
                    var id = mydatatable.row(indexes[0]).id();
                    var action = "edit";
                } else {
                    var action = $(this).data("action");
                }

                let url = "/waterquality/" + action;
                if (action == "edit") {
                    url += "/" + id;
                }

                // Add & Update

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        $("#modal-content").html(data);
                        $(".modal-title").text(action.toUpperCase() + " Water Quality");
                        $("#modal-errors").addClass("d-none");
                        $('#editwaterqualities').modal({
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
            $('#editwaterqualities').on('shown.bs.modal', function() {
                $('#myInput').focus();
            });

            $('#editwaterqualities').on('hidden.bs.modal', function() {
                $("#modal-errors").addClass("d-none");
                $(".modal-footer").unbind("click");
            });
        });
    };

    function deleteWaterQuality(id, name) {
        if (confirm("Are you sure you want to delete " + name)) {
            $.ajax({
                url: '/waterquality/delete/' + id,
                type: 'DELETE',
                success: function(result) {
                    window.location = "/waterquality";
                }
            });
        }
    }

</script>
@endsection
