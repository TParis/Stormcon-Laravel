<div class="operators">
    <div class="container-fluid add-item-container">
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-info add-item" onClick="addOperator()">+</button>
            </div>
        </div>
    </div>
@foreach ($operators as $operator)
    @includeWhen($operator->{"operator_" . $operator->index . "_name"} != "", 'project.operators.forms.edit', ["iter" => $loop->iteration])
@endforeach
</div>

<script>
    $(document).ready(function () {
        if ($(".operators").children().length === 1) {
            addOperator()
        }
    });

    function addOperator() {
        num = $(".operators").children().length;

        if (num < 7) {
            $.get({
               url: "/projects/getNewView/operator/" + num,
               success: function(data) {
                   $(".operators").append(data);
               }
            });
        }
   }
</script>
