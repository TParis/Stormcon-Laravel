<table class="table table-primary table-bordered">
    <thead>
        <th>Inspector</th>
        <th>Sunday</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
    </thead>
    <tbody>

        @foreach ($inspectors as $name => $schedule)
            <tr>
            @php
                $schedule = $schedule->groupBy('dayOfWeek')
            @endphp
                <td>{{ $name }}</td>
                <td>{{ isset($schedule['Sunday']) ? $schedule['Sunday']->count() : 0 }}</td>
                <td>{{ isset($schedule['Monday']) ? $schedule['Monday']->count() : 0 }}</td>
                <td>{{ isset($schedule['Tuesday']) ? $schedule['Tuesday']->count() : 0 }}</td>
                <td>{{ isset($schedule['Wednesday']) ? $schedule['Wednesday']->count() : 0 }}</td>
                <td>{{ isset($schedule['Thursday']) ? $schedule['Thursday']->count() : 0 }}</td>
                <td>{{ isset($schedule['Friday']) ? $schedule['Friday']->count() : 0 }}</td>
                <td>{{ isset($schedule['Saturday']) ? $schedule['Saturday']->count() : 0 }}</td>
            </tr>
        @endforeach

    </tbody>
</table>

