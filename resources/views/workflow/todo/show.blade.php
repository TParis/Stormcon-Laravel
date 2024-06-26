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
            <div class="row">
                <div class="col-9">
                    <div class="card-body">
                        <div>Type:</div>
                        <div class="pl-3">Checklist</div>
                        <div>Steps:</div>
                        <div style="font-size: 10pt;" class="pl-3">
                        @foreach($item->checklist as $task)
                            {{ $task["task"] }} <br />
                        @endforeach
                        </div>
                        <div>Team:</div>
                        <div class="pl-3">{{ $item->role }}</div>
                        <div>Est Hours:</div>
                        <div class="pl-3">{{ $item->day }}</div>
                        <div>Inspectable:</div>
                        <div class="pl-3">{{ ($item->inspectable) ? "Yes" : "No" }}</div>
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
