<h3>Other Controls</h3>
<table class="table table-bordered" id="other_controls_table">
    <thead>
    <tr>
        <th scope="col">Control Practice Used</th>
        <th scope="col">Location(s) On-Site</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("other_control_{$i}_bmp", $bmps_selection, $project->{"other_control_{$i}_bmp"} ?? '', ['class' => 'form-control', 'data-index' => $i, 'list' => 'other_controls_bmps']) }}</td>
            <td>{{ Form::text("other_control_{$i}_location", $project->{"other_control_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    </tbody>
</table>
