@extends('layout.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ Route("Home") }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ Route("workflow_template::index") }}">Workflow Templates</a></li>
        <li class="breadcrumb-item">{{ $template->name }}</li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (count($errors))
        <div class="alert alert-danger">
            <p>Errors: {{ count($errors) }}</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <h3>Add Step</h3>
                <div class="table-bordered border-dark p-3">
                    {{ Form::open(array('route' => array('workflow_template::item::create', $template->id), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
                    {{ Form::label('name', 'Step Name', array('class' => 'control-label required-field')) }}
                    {{ Form::text('name', '', array('class' => 'form-control')) }}
                    {{ Form::label('type', 'Type', array('class' => 'control-label required-field')) }}
                    {{ Form::select('type', ['email' => "E-Mail", 'todo' => "To-Do List"], [],array('class' => 'form-control', 'placeholder' => 'Please select')) }}
                    <div id="options"></div>
                    {{ Form::label('days', 'Est. Days', array('class' => 'control-label required-field')) }}
                    {{ Form::text('days', '', array('class' => 'form-control')) }}
                    <button class="btn btn-success w-100 mt-3">Add Task</button>
                    {{ Form::close() }}
                </div>
                <button class="btn btn-danger w-100 mt-3">Delete Template</button>
                <a href="{{ route("workflow_template::index") }}" class="btn btn-info w-100 mt-3">Return to List</a>

            </div>
            <div class="col-4 offset-1">
                <h1 align="center">START</h1>
                @foreach ($template->sub_items() as $item)
                    <div class="flex text-center mt-1 mb-1"style="font-size: 26pt">
                        <i class="fas fa-arrow-down ml-auto mr-auto"></i>
                    </div>
                    @include($item::view . "show", $item)
                @endforeach
                <div class="flex text-center mt-1 mb-1"style="font-size: 26pt">
                    <i class="fas fa-arrow-down ml-auto mr-auto"></i>
                </div>
                <h1 align="center">END</h1>
            </div>
            <div class="col-3 offset-1">
                <h3 align="right">Files</h3>
                <div class="container-fluid border project-block">
                    <label class="form-check-label" for="taska">
                        <div><input type="checkbox" name="maps"/> <i class="fas fa-folder"></i> Maps</div>
                        <div><input type="checkbox" name="maps"/> <i class="fas fa-folder"></i> Folder</div>
                        <div><input type="checkbox" name="maps"/> <i class="fas fa-file"></i> Research.docx</div>
                        <div><input type="checkbox" name="maps"/> <i class="fas fa-file"></i> SWPPP.docx</div>
                    </label>
                </div>

            </div>
        </div>
    </div>
@endsection

@section("scripts")
<script type="text/javascript">

    $("form #type").change(function(e) {
        val = $(e.target).val()
        let url = '/workflow-template/todo/create'
        if (val === 'email') url = '/workflow-template/email/create'

        $.get({
            url: url,
            success: function(data) {
                $("#options").html(data);
            }
        });
    })

</script>
@endsection
