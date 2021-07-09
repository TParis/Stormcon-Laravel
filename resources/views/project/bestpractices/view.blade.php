<div class="bestpractices">
    @foreach ($bmps as $bmp)
        @php
        $checked = (is_array($project->bmps) && in_array($bmp->description, $project->bmps)) ? 'checked' : '';
        @endphp
        <div class="form-check mb-5">
            <input class="form-check-input" {{ $checked }} name="bmps[]" type="checkbox" value="{{ $bmp->description }}" id="bmp-{{ $bmp->id }}">
            <label class="form-check-label" for="bmp-{{ $bmp->id }}">
                {{ $bmp->description }}
            </label>
        </div>
    @endforeach
</div>
