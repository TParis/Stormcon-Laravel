@if (get_class($project->workflow->step()) == "App\\Models\\WorkflowToDoItem")
<div id="assigned"><strong>Assigned:</strong>
    @if(isset($project->workflow->step()->user_id))
        {{ $project->workflow->step()->assigned->fullName }}
    @else
        <a href="#" data-toggle="modal" data-target="#assignee-modal">Unassigned</a>
    @endif
</div>
@endif
<div class="modal" id="assignee-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-control" name="assignee-list"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn save-assignee btn-primary" data-dismiss="modal">Save message</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">


    function getList() {

        $.ajax({
            url: '/api/role/{{ $project->workflow->step()->role }}/users',
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            success: function (personnel) {
                $("select[name='assignee-list']").html("")
                $.each(personnel, function (key, value) {
                    $("select[name='assignee-list']")
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name + " (" + value.projects + " assigned)"));
                });
            }
        });
    }

    $('#assignee-modal').on('shown.bs.modal', function () {
        getList();
    });

    $(".save-assignee").on("click", function() {

        $.ajax({
            url: '/api/workflow/{{ $project->workflow->id }}/assign/' + $("select[name='assignee-list']").val(),
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            success: function (assignee) {
                $("#assigned").html("<strong>Assigned:</strong> " + assignee.fullName);
            }
        });
    })

</script>
