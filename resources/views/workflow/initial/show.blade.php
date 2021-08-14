<div class="accordion" id="accordion-init-{{ $item->id }}">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-init-{{$item->id}}" aria-expanded="true" aria-controls="collapse-init-{{$item->id}}">
                    {{ $item->name }}
                </button>
            </h2>
        </div>

        <div id="collapse-init-{{$item->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-init-{{ $item->id }}">
            <div class="row">
                <div class="col-9">
                    <div class="card-body">
                        <div>Type:</div>
                        <div class="pl-3">Email</div>
                        <div>Role:</div>
                        <div class="pl-3">NOI, Research, Inspection</div>
                        <div>Subject:</div>
                        <div class="pl-3">New Project Created</div>
                    </div>
                </div>
                <div class="col-3">
                    <button data-id="{{ $loop->index }}" data-action="up" class="workflow-button up-button"><i class="fas fa-arrow-up"></i></button>
                    <button data-id="{{ $loop->index }}" data-action="down"  class="workflow-button down-button"><i class="fas fa-arrow-down"></i></button>
                    <button data-id="{{ $loop->index }}" data-action="delete"  class="workflow-button delete-button"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
