<h3>Support Facilities</h3>
<table class="table table-bordered" id="support_facilities_table">
    <thead>
    <tr>
        <th scope="col">Facility</th>
        <th scope="col">Description</th>
        <th scope="col">Location</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i <= 6; $i++)
        <tr>
            <td>{{ Form::text("support_facility_{$i}_name", $project->{"support_facility_{$i}_name"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
            <td>{{ Form::text("support_facility_{$i}_description", $project->{"support_facility_{$i}_description"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
            <td>{{ Form::text("support_facility_{$i}_location", $project->{"support_facility_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
        </tr>
    @endfor
    </tbody>
</table>
