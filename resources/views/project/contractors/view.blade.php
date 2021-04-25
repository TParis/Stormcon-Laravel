<div class="contractors">
    <div class="container-fluid add-item-container">
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-info add-item" onClick="addContractor()">+</button>
            </div>
        </div>
    </div>
    @foreach ($contractors as $contractor)
        @includeWhen($contractor->{"contractor_" . $contractor->index . "_name"} != "", 'project.contractors.forms.edit', ["iter" => $loop->iteration])
    @endforeach
</div>

<script>
    $(document).ready(function () {
        if ($(".contractors").children().length === 1) {
            addContractor()
        }
    });

    function addContractor() {
        num = $(".contractors").children().length;

        if (num < 7) {
            $.get({
                url: "/projects/getNewView/contractor/" + num,
                success: function(data) {
                    $(".contractors").append(data);
                }
            });
        }
    }
</script>
