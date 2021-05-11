<div class="container">
    <div class="row">
        <div class="col-12 text-right">
            <a href="{{ route("project::export", $project->id) }}" class="btn btn-primary">Export</a>
        </div>
    </div>
    <ul>
    @foreach ($project->export() as $key => $value)
        @if (!is_array($value))
        <li>${<!-- -->{{ $key }}} => {{ $value }}</li>
        @endif
    @endforeach
    </ul>
</div>
