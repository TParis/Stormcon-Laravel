<div class="accordion" id="accordion-todo-{{ $item->id }}">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-todo-{{$item->id}}" aria-expanded="true" aria-controls="collapse-todo-{{$item->id}}">
                    {{ $item->name }}
                </button>
            </h2>
        </div>

        <div id="collapse-todo-{{$item->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-todo-{{ $item->id }}">
            <div class="card-body">
                <div>Type:</div>
                <div class="pl-3">Email</div>
                <div>Role:</div>
                <div class="pl-3">NOI, Research, Inspection</div>
                <div>Subject:</div>
                <div class="pl-3">New Project Created</div>
            </div>
        </div>
    </div>
</div>
