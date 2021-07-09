<div class="providers">
    <div class="container-fluid add-item-container">
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-info add-item" onClick="addProvider()">+</button>
            </div>
        </div>
    </div>
    @foreach ($providers as $provider)
        @includeWhen($provider->{"provider_" . $provider->index . "_name"} != "", 'project.providers.forms.edit', ["iter" => $loop->iteration])
    @endforeach
</div>

<script>
    $(document).ready(function () {
        if ($(".providers").children().length === 1) {
            addProvider()
        }
    });

    function addProvider() {
        num = $(".providers").children().length;

        if (num < 7) {
            $.get({
                url: "/projects/getNewView/provider/" + num,
                success: function(data) {
                    $(".providers").append(data);
                }
            });
        }
    }
</script>
