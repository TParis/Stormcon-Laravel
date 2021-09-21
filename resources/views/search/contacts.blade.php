<div class="container-fluid border-dark table-bordered border-info mb-1">
    <div class="row">
        <div class="col-1"><strong>Type</strong></div>
        <div class="col-2"><strong>Name</strong></div>
        <div class="col-3"><strong>Company</strong></div>
        <div class="col-3"><strong>Title</strong></div>
        <div class="col-3"><strong>Updated</strong></div>
    </div>
    <div class="row">
        <div class="col-1">Contact</div>
        <div class="col-2"><a href="{{ route("contact::view", $result["id"]) }}">{{ $result["first_name"] }} {{ $result["last_name"] }}</a></div>
        <div class="col-3">{{  call_user_func(array($result["employer_type"], "find"), $result["employer_id"])->name }}</div>
        <div class="col-3">{{ $result["title"] }}</div>
        <div class="col-3">{{ $result["updated_at"] }}</div>
    </div>
</div>
