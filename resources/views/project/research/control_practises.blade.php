<h3>Control Practices</h3>
<table class="table table-bordered" id="control_practices_table">
    <thead>
    <tr>
        <th scope="col">Stabilization Practices</th>
        <th scope="col">Location On-Site</th>
        <th scope="col">Implementation Date</th>
        <th scope="col">Interim or Permanent</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i <= 4; $i++)
        <tr>
            <td>{{ Form::select("control_practice_{$i}_bmp", $bmps_selection, $project->{"control_practice_{$i}_bmp"} ?? '', ['class' => 'form-control control-practice-bmp', 'data-index' => $i, 'list' => 'control_practices_bmps']) }}</td>
            <td>{{ Form::text("control_practice_{$i}_location", $project->{"control_practice_{$i}_location"} ?? '', ['class' => 'form-control', 'maxlength' => 255]) }}</td>
            <td>{{ Form::date("control_practice_{$i}_bmp_implementation_date", $project->{"control_practice_{$i}_bmp_implementation_date"} ? date('Y-m-d', strtotime($project->{"control_practice_{$i}_bmp_implementation_date"})) : '', ['class' => 'form-control']) }}</td>
            <td>{{ Form::select("control_practice_{$i}_interim_or_permanent",["","Interim", "Permenant"], $project->{"control_practice_{$i}_interim_or_permanent"} ?? '', ['class' => 'form-control', 'maxlength' => 9]) }}</td>
        </tr>
    @endfor
    </tbody>
</table>

<script>
    let bmps = @json($bmps->toArray());

    $('.control-practice-bmp').on('change', function () {
        let index = $(this).attr('data-index');

        if (typeof index !== 'undefined') {
            let bmp_name = this.value;
            let inputSelector = $(`input[name="control_practice_${index}_interim_or_permanent"]`);

            if (bmp_name.length > 0 && bmps.length > 0) {
                let bmp = bmps.find(x => bmp_name === x.name);

                if (typeof bmp !== 'undefined') {
                    inputSelector.val(bmp.interim_or_permanent);
                    return true;
                }
            }

            inputSelector.val('');
        }

        return false;
    });
</script>
