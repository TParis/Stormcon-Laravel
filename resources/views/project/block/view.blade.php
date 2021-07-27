
<div id="blocked-status"><strong>Status:</strong>
@if ($project->workflow->status != 3)
    <span id="status">Open</span>
@else
    <span id="status">Blocked</span>
@endif
</div>
<div class="modal" id="block-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Block Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" name="block-message"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn save-block btn-primary" data-dismiss="modal">Save message</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $(".save-b  lock").on("click", function() {

            $.ajax({
                url: '/api/workflow/{{ $project->workflow->id }}/block',
                headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
                method: 'POST',
                data: {
                    message: $("select[name='block-message']").val()
                },
                success: function (assignee) {
                    $("#status").html("Blocked");
                    alert("Project Blocked");
                },
                error: function(assignee) {
                    alert("Error")
                }
            });
        })

        $("#save-unblock").on("click", function() {

            $.ajax({
                url: '/api/workflow/{{ $project->workflow->id }}/unblock/',
                headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
                success: function (assignee) {
                    $("#status").html("Open");
                    alert("Project Unblocked");
                },
                error: function(assignee) {
                    alert("Error")
                }
            });
        });
    });

</script>
