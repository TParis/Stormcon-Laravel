@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Users</li>
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
        <button class="btn btn-info add-btn" data-action="add"><i class="glyphicon glyphicon-plus"></i> Add New User</button>
		<table id="users" class="table table-sortable table-bordered table-striped display">
			<thead>
				<tr>
					<th>Username</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Active</th>
					<th>Modified</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($users as $user)
				<tr id="{{ $user->id }}">
					<td>{{ $user->username }}</td>
					<td>{{ $user->fullName }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->active)
                        <td>Active</td>
                    @else
                        <td>Inactive</td>
                    @endif
					<td>{{ $user->updated_at }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<button class="btn btn-info add-btn" data-action="add"><i class="glyphicon glyphicon-plus"></i> Add New User</button>
    <div class="modal fade" tabindex="-1" role="dialog" id="editusers">
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

        $("#users").ready(function() {
            let mydatatable = $("#users").DataTable({
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

                let url = "/users/" + action;
                if (action == "edit") {
                    url += "/" + id;
                }

                // Add & Update

                if (action !== "delete") {

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            $("#modal-content").html(data);
                            $(".modal-title").text(action.toUpperCase() + " USER");
                            $("#modal-errors").addClass("d-none");
                            $('#editusers').modal({
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

                    // Delete

                } else {

                    let oldBGcolor = $(this).closest(".datasheet-item").css("background-color");
                    $(this).closest(".datasheet-item").css("background-color", "red");

                    // Have to do it this way because the coloring was ending up after the confirm() dialog in the asychronus jQuery stack because of h
                    let deleteFunction = function() {

                        if (!confirm("Are you sure you want to delete this " + $(this).data("target") + "?")) {
                            $(this).closest(".datasheet-item").css("background-color", oldBGcolor);
                            return false;
                        }

                        //Intentionally ask them twice if it's an entire datasheet
                        if ($(this).data("target").toLowerCase() === "datasheet" && !confirm("You are about to delete the ENTIRE datasheet and all su")) {
                            return false;
                        }

                        $.ajax({
                            url: url,
                            type: 'delete',
                            context: $(this),
                            success: function(data) {
                                window.location = "/";
                            },
                            error: function(data) {

                                console.log(data);

                                if (data.status == "401") {
                                    location.href = "/";
                                } else {
                                    alert("An error has occured.  See log for details.");
                                    console.log('Error:', data);
                                }
                            }
                        });

                    }

                    setTimeout(deleteFunction.bind(this), 100);
                }


            };

            //Modal fixer
            $('#editusers').on('shown.bs.modal', function() {
                $('#myInput').focus();
            });

            $('#editusers').on('hidden.bs.modal', function() {
                $("#modal-errors").addClass("d-none");
                $(".modal-footer").unbind("click");
            });
        });
    };

    function deleteUser(id, name) {
        if (confirm("Are you sure you want to delete " + name)) {
            $.ajax({
                url: '/users/delete/' + id,
                type: 'DELETE',
                success: function(result) {
                    window.location = "/users";
                }
            });
        }
    }

</script>
@endsection
