<h3>BMPs, Off-Site Transfer of Pollutant Controls</h3>

<table class="table table-bordered" id="bmps_off_site_transfer_of_pollutant_controls">
    <tbody>
    <tr>
        <th scope="col" colspan="2">Litter Controls:</th>
    </tr>
    <tr>
        <th scope="col">Good Housekeeping Activity</th>
        <th scope="col">Location(s) On-Site</th>
    </tr>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("off_site_transfer_pollutant_controls_litter_{$i}_bmp", $bmps_selection, $project->{"off_site_transfer_pollutant_controls_litter_{$i}_bmp"} ?? '', ['class' => 'form-control', 'list' => 'off_site_transfer_pollutant_controls_litter_bmps']) }}</td>
            <td>{{ Form::text("off_site_transfer_pollutant_controls_litter_{$i}_location", $project->{"off_site_transfer_pollutant_controls_litter_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    <tr>
        <th scope="col" colspan="2">Construction Debris Controls:</th>
    </tr>
    <tr>
        <th scope="col">Good Housekeeping Activity</th>
        <th scope="col">Location(s) On-Site</th>
    </tr>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("off_site_transfer_pollutant_controls_debris_{$i}_bmp", $bmps_selection, $project->{"off_site_transfer_pollutant_controls_debris_{$i}_bmp"} ?? '', ['class' => 'form-control', 'list' => 'off_site_transfer_pollutant_controls_debris_bmps']) }}</td>
            <td>{{ Form::text("off_site_transfer_pollutant_controls_debris_{$i}_location", $project->{"off_site_transfer_pollutant_controls_debris_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    <tr>
        <th scope="col" colspan="2">Construction Material Controls:</th>
    </tr>
    <tr>
        <th scope="col">Good Housekeeping Activity</th>
        <th scope="col">Location(s) On-Site</th>
    </tr>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("off_site_transfer_pollutant_controls_materials_{$i}_bmp", $bmps_selection, $project->{"off_site_transfer_pollutant_controls_materials_{$i}_bmp"} ?? '', ['class' => 'form-control', 'list' => 'off_site_transfer_pollutant_controls_materials_bmps']) }}</td>
            <td>{{ Form::text("off_site_transfer_pollutant_controls_materials_{$i}_location", $project->{"off_site_transfer_pollutant_controls_materials_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    </tbody>
</table>
