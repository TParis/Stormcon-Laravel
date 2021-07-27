<div class="accordion" id="accordion-email-{{ $item->id }}">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-email-{{$item->id}}" aria-expanded="true" aria-controls="collapse-email-{{$item->id}}">
                    {{ $item->name }}
                </button>
            </h2>
        </div>

        <div id="collapse-email-{{$item->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-email-{{ $item->id }}">
            <div class="card-body">
                <div>Type:</div>
                <div class="pl-3">Email</div>
                <div>Role:</div>
                <div class="pl-3">{{ $item->role }}</div>
                <div>Subject:</div>
                <div class="pl-3">{{ $item->subject }}</div>
                <div>Body:</div>
                <div class="pl-3">{{ $item->subject }}</div>
            </div>
        </div>
    </div>
</div>
