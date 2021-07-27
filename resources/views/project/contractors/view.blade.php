<div class="contractors">
    <div class="container-fluid add-item-container" style="pointer-events:none;">
        <div class="row" style="pointer-events:none;">
            <div class="col-12 text-right" style="pointer-events:none;">
                <button type="button" class="btn btn-info add-item" style="pointer-events: all;" onClick="addContractor()">+</button>
            </div>
        </div>
    </div>
    @foreach ($project->contractors as $contractor)
        @include('project.contractors.forms.edit', compact("contractor"))
    @endforeach
</div>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        if ($(".contractors").children().length === 1) {
            addContractor()
        }
    });

    function addContractor() {
        num = $(".contractors").children().length;

        if (num < 7) {
            $.get({
                url: "/projects/getNewView/contractor/{{ $project->id }}",
                success: function(data) {
                    $(".contractors").append(data);
                }
            });
        }
    }

    function delContractor(id) {
        $.ajax({
            url: "/contractor/delete/" + id,
            method: "DELETE",
            success: function() {
                $("#contractor-" + id).remove();
                alert("Contactor has been deleted.")
            },
            error: function() {
                alert("Contactor could not be deleted.")
            }
        });
    }

    var contact_list = {!! $contacts->toJson() !!};

    $(".contractors").on("change", ".contact-name", function(e) {

        prefix = e.target.name.substring(0, e.target.name.indexOf("_", e.target.name.indexOf("_")+1))

        contact_id = $("select[name='" + prefix + "_contact_name']").find(":selected")[0].id;
        contact_obj = contact_list.find(element => element.id == contact_id);

        $("input[name='" + prefix + "_contact_phone'").val(contact_obj.phone)
        $("input[name='" + prefix + "_contact_fax'").val(contact_obj.fax)
        $("input[name='" + prefix + "_contact_email'").val(contact_obj.email)
        $("input[name='" + prefix + "_contact_title'").val(contact_obj.title)

    });

    $(".contractors").on("change", ".noi-signer-name", function(e) {

        prefix = e.target.name.substring(0, e.target.name.indexOf("_", e.target.name.indexOf("_")+1))

        contact_id = $("select[name='" + prefix + "_noi_signer_name']").find(":selected")[0].id;
        contact_obj = contact_list.find(element => element.id == contact_id);

        $("input[name='" + prefix + "_noi_signer_title'").val(contact_obj.title)

    });
    $(".contractors").on("change", ".not-signer-name", function(e) {

        prefix = e.target.name.substring(0, e.target.name.indexOf("_", e.target.name.indexOf("_")+1))

        contact_id = $("select[name='" + prefix + "_not_signer_name']").find(":selected")[0].id;
        contact_obj = contact_list.find(element => element.id == contact_id);

        $("input[name='" + prefix + "_not_signer_title'").val(contact_obj.title)

    });



</script>
