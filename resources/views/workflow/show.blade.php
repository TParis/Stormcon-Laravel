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
                <h3>Add Task</h3>
                <div class="table-bordered border-dark p-3">
                    {{ Form::open(array('route' => array('workflow_template::item::create', $template->id), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
                    {{ Form::label('name', 'Step Name', array('class' => 'control-label required-field')) }}
                    {{ Form::text('name', '', array('class' => 'form-control', 'required' => 'required')) }}
                    {{ Form::label('type', 'Type', array('class' => 'control-label required-field')) }}
                    {{ Form::select('type', ['inspection' => 'Inspection Phase', 'email' => "E-Mail", 'todo' => "Checklist"], [],array('class' => 'form-control', 'placeholder' => 'Please select')) }}
                    <div id="options"></div>
                    <button class="btn btn-success w-100 mt-3">Add Task</button>
                    {{ Form::close() }}
                </div>
                <a href="{{ route("workflow_template::destroy", $template->id) }}" class="btn btn-danger w-100 mt-3">Delete Template</a>
                <a href="{{ route("workflow_template::index") }}" class="btn btn-info w-100 mt-3">Return to List</a>

            </div>
            <div class="workflow-list col-4 offset-1">
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
                <h3 align="right">File Templates</h3>
                @if (Auth::user()->need_token())
                    <h2>Please login to the Microsoft API (allow popups)</h2>
                @else
                <div class="container-fluid border project-block">
                    <label class="form-check-label">
                        @foreach ($folders as $folder)
                            <div><input type="radio" {{ ($template->template == $folder["filename"]) ? "checked" : "" }} name="template" value="{{ $folder["filename"] }}"/> <i class="fas fa-folder"></i> {{ $folder["filename"] }}</div>
                        @endforeach
                    </label>
                </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section("scripts")
<script type="text/javascript">

    $(document).ready(function() {

        $("form #type").change(function(e) {
            val = $(e.target).val()
            let url = '{{ route('workflow_template::todo::create') }}'
            if (val === 'email') url = '{{ route('workflow_template::email::create') }}'
            if (val === 'initial') url = '/workflow-template/initial/create'
            if (val === 'inspection') url = '/workflow-template/inspection/create'

            $.get({
                url: url,
                success: function(data) {
                    $("#options").html(data);
                }
            });
        })

        $("input[type='radio']").click(function(e) {
            val = $(e.target).val()
            $.get({
                url: '{{ route('workflow_template::template::update', $template->id) }}',
                data: {
                    template: val
                }
            })
        })

        function sortWorkflowList(e) {
            id = ($(e.target.parentNode).data("id") === undefined) ? $(e.target).data("id") : $(e.target.parentNode).data("id");
            action = ($(e.target.parentNode).data("action") === undefined) ? $(e.target).data("action") : $(e.target.parentNode).data("action");

           $(".workflow-list").off("click", ".workflow-button", sortWorkflowList);

           $.ajax({
               url: "{{ route("workflow::template::item::sort", $template->id) }}/" + id + "/" + action,
               method: "POST",
               data: {
                   'api_token': '{{ Auth::user()->api_token }}',
               },
               success: function (data) {
                    $(".workflow-list").html(data);

               },
               error: function(data) {
                   alert("Could not update workflow list.  Please try again.")
               },
               complete: function() {
                   $(".workflow-list").on("click", ".workflow-button", sortWorkflowList);
               }
           });


        }


        $(".workflow-list").on("click", ".workflow-button", sortWorkflowList);

        $(".btn-danger").click(function(e) {
            if(!confirm("Are you sure you want to delete this workflow?")) {
                e.preventDefault();
            }
        });

    });

</script>
@endsection
