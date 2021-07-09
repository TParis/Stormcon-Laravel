<div class="messages" style="overflow-y: scroll; width:100%; height: 100%">

</div>
<div class="modal" id="message-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea type="text" rows=5 cols=75 name="message" placeholder="Message text"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn save-message btn-primary" data-dismiss="modal">Save message</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function getMessages() {

        $.ajax({
            url: '/api/notes/{{ $project->id }}',
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            success: function (data) {

                //Clear Current
                $(".messages").html("");

                data.forEach(function (message) {
                    date = new Date(message.created_at)
                    date_formatted = date.toLocaleString('en-US')
                    text = "<b>[" + date_formatted + "]<br />" + message.name + ":</b> " + message.message;
                    $(".messages").append(
                        $("<div>").html(text).addClass("mb-2")
                    );
                });
            }
        });
    }

    //start
    getMessages()
    window.setInterval(getMessages, 10000);

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

    $(".save-message").on('click', function() {
        $.ajax({
            url: '/api/notes/create/{{ $project->id }}',
            method: 'POST',
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            data: {
                name: '{{ Auth::user()->fullName }}',
                message: $("textarea[name='message']").val()
            },
            success: function () {
                getMessages()
            },
            error: function () {
                alert("Could not save message")
            }
        })
    });

</script>
