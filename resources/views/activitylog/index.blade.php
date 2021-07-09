@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
    </ol>
    <div class="container-fixed">
        <table id="logs" class="table table-sortable table-bordered table-striped display">
            <thead>
            <tr>
                <th>Date/Time</th>
                <th>Source</th>
                <th>Log Level</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->timestamp }}</td>
                    <td>{{ $log->env }}</td>
                    <td>{{ $log->type }}</td>
                    <td>{{ $log->message }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section("scripts")
    <script language="javascript" type="text/javascript">
        window.onload = function () {

            $("#logs").DataTable( {
                "order": [[ 0, "desc" ]]
            });
        }

    </script>
@endsection
