<div class="bestpractices">
    @foreach ($bmps as $bmp)
        @php
        $checked = (is_array($project->bmps) && in_array($bmp->name, $project->bmps)) ? 'checked' : '';
        @endphp
        <div class="form-check">
            <input class="form-check-input" {{ $checked }} name="bmps[]" type="checkbox" value="{{ $bmp->name }}" id="bmp-{{ $bmp->id }}">
            <label class="form-check-label" for="bmp-{{ $bmp->id }}">
                {{ $bmp->name }}
            </label>
        </div>
    @endforeach
</div>
