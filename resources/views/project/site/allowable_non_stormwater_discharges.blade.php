<h3>List of Allowable Non-Stormwater Discharges Present at the Site</h3>
<table class="table table-bordered" id="has_allowable_discharges_table">
    <thead>
    <tr>
        <th scope="col">Type of Allowable Non-Stormwater Discharge</th>
        <th scope="col">Likely to be Present at Your Site?</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_fire_fighting', 'Discharges from emergency fire-fighting activities', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_fire_fighting', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_fire_fighting'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_fire_hydrant', 'Fire hydrant flushings', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_fire_hydrant', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_fire_hydrant'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_landscape_irrigation', 'Landscape irrigation', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_landscape_irrigation', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_landscape_irrigation'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_water_to_wash_vehicles_and_equipment', 'Waters used to wash vehicles and equipment', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_water_to_wash_vehicles_and_equipment', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_water_to_wash_vehicles_and_equipment'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_water_to_control_dust', 'Waters used to control dust', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_water_to_control_dust', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_water_to_control_dust'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_potable_water', 'Potable water including uncontaminated water line flushings', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_potable_water', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_potable_water'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_building_wash_down', 'Routine external building wash down', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_building_wash_down', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_building_wash_down'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_pavement_wash_waters', 'Pavement wash waters', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_pavement_wash_waters', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_pavement_wash_waters'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_compressor_or_air_conditioner_condensate', 'Uncontaminated air conditioning or compressor condensate', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_compressor_or_air_conditioner_condensate', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_compressor_or_air_conditioner_condensate'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_non_turbid_ground_or_spring_water', 'Uncontaminated, non-turbid discharges of ground water or spring water', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_non_turbid_ground_or_spring_water', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_non_turbid_ground_or_spring_water'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('has_allowable_discharge_foundation_or_footing_drains', 'Foundation or footing drains', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::select('has_allowable_discharge_foundation_or_footing_drains', ['' => '', 'Yes' => 'Yes', 'No' => 'No'], $project->{'has_allowable_discharge_foundation_or_footing_drains'} ?? '', ['class' => 'form-control']) }}</td>
    </tr>
    </tbody>
</table>
