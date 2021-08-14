@extends('layout.app')

@section('content')

    <h1>Inspections</h1>

    <table id="inspection_schedule" class="table">
        <thead>
        @if (Auth::user()->can('viewInspections'))
        <th>Inspector</th>
        @endif
        <th>Status</th>
        <th class="d-none d-sm-none d-md-table-cell">Ready to NOT</th>
        <th class="d-none d-sm-none d-md-table-cell">NOT'd</th>
        <th>Project #</th>
        <th class="d-none d-sm-none d-md-table-cell">Project Title</th>
        <th>Address</th>
        <th>Format</th>
        <th class="d-none d-sm-none d-md-table-cell">Cycle</th>
        <th class="d-none d-sm-none d-md-table-cell">Last Inspection</th>
        <th class="d-none d-sm-none d-md-table-cell">Photos</th>
        </thead>
        <tbody>
        @foreach ($inspections as $inspection)
            @if (Auth::user()->can('viewInspections'))
            <td>{{ $inspection->inspector->fullName }}</td>
            <td>{{ $inspection->status }} </td>
            @else
            <td><button class="btn btn-primary">Mark Complete</button></td>
            @endif
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->project->rdy_to_noi }}</td>
            <td class="d-none d-sm-none d-md-table-cell"></td>
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->project->rdy_to_not }}</td>
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->project->name }}</td>
            <td><a href="https://www.google.com/maps/place/{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}, {{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}" target="_blank">{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}<br \>{{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}</td>
            <td>{{ $inspection->project->inspection_format }}</td>
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->project->inspection_cycle }} days</td>
            <td class="d-none d-sm-none d-md-table-cell">{{ $inspection->updated_at }}</td>
            <td><button class="btn btn-primary">Upload</button></td>
        @endforeach
        </tbody>
    </table>

    @if (Auth::user()->can('viewInspections'))
    <script type="text/javascript">
        $("#inspection_schedule").DataTable();
    </script>
    @endif

@endsection
