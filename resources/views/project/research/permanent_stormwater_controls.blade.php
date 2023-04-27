<h3>Permanent Stormwater Controls</h3>
<table class="table table-bordered" id="permanent_stormwater_controls_table">
    <thead>
    <tr>
        <th scope="col">Control Measure</th>
        <th scope="col">Location on Project Site</th>
        <th scope="col">Control runoff from what areas</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("permanent_stormwater_control_{$i}_bmp", $bmps_selection, $project->{"permanent_stormwater_control_{$i}_bmp"} ?? '', ['class' => 'form-control', 'data-index' => $i, 'list' => 'permanent_stormwater_controls_bmps']) }}</td>
            <td>{{ Form::text("permanent_stormwater_control_{$i}_location", $project->{"permanent_stormwater_control_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
            <td>{{ Form::text("permanent_stormwater_control_{$i}_runoff_areas", $project->{"permanent_stormwater_control_{$i}_runoff_areas"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    </tbody>
</table>
