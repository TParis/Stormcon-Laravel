<div class="container-fluid border-dark table-bordered border-info mb-1">
    <div class="row">
        <div class="col-1"><strong>Type</strong></div>
        <div class="col-4"><strong>Name</strong></div>
        <div class="col-4"><strong>Location</strong></div>
        <div class="col-3"><strong>Updated</strong></div>
    </div>
    <div class="row">
        <div class="col-1">Company</div>
        <div class="col-4"><a href="{{ route("company::view", $result["id"]) }}">{{ $result["name"] }}</a></div>
        <div class="col-4">{{ $result["city"] }}, {{ $result["state"] }}</div>
        <div class="col-3">{{ $result["updated_at"] }}</div>
    </div>
</div>
