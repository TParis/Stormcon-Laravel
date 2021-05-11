<div class="contractors">
    <div class="container-fluid add-item-container">
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-info add-item" onClick="addContractor()">+</button>
            </div>
        </div>
    </div>
    @foreach ($project->contractors as $contractor)
        @include('project.contractors.forms.edit', compact("contractor"))
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
                url: "/projects/getNewView/contractor/{{ $project->id }}",
                success: function(data) {
                    $(".contractors").append(data);
                }
            });
        }
    }
</script>
