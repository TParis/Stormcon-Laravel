@extends("layout.app")

@section("content")
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route("Home") }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route("project::index") }}">Projects</a></li>

        @if ($project->id != "")
            <li class="breadcrumb-item">{{ $project->name }} #{{ $project->id }}</li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        @else
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        @endif

    </ol>
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (count($errors))
        <p>Errors: {{ count($errors) }}</p>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($project->id != "")
        <div class="container" style="overflow-x: scroll;">
        <div class="workflow-timeline" style="min-width: 100%; width: {{ $project->workflow->sub_items()->count() * 120 }}px">
            @foreach ($project->workflow->sub_items() as $step)
                @if ($loop->index == $project->workflow->step)
                    <div class="workflow-item active">{{ $step->name }}</div>
                @else
                    <div class="workflow-item">{{ $step->name }}</div>
                @endif
            @endforeach
            </div>
        </div>
        <h1>{{ $project->proj_number }} &mdash; {{ $project->name }}</h1>
    @else
        <h1>Create Project</h1>
    @endif
    <div class="container-fluid projects">
        <div class="row">
            @if ($project->id != "")
            <div class="col-3">

                @include("project.assigned.view")
                @include("project.block.view")
                <strong>NOIs Signed:</strong> {{ $project->contractors->sum('noi_signed') }} / {{ $project->contractors->count() }}<br />
                <strong>NOTs Signed:</strong> {{ $project->contractors->sum('not_signed') }} / {{ $project->contractors->count() }}
                @if (($project->workflow->step()->role && Auth::user()->hasRole($project->workflow->step()->role)) ||
                        Auth::user()->hasRole(['Owner', 'Admin', 'Sr Admin']))
                <h3 align="right" class="project-block-header">Actions</h3>
                <div class="container-fluid border project-block">
                    <a href="#" data-toggle="modal" data-target="#block-modal">Add Blocker</a>
                    <a href="#" class="w-100 d-block" id="save-unblock">Clear Blocker</a>
                    <hr>
                    <a href="{{ route("project::reverse-step", $project->id) }}" class="w-100 d-block">Return to Previous Step</a>
                    <a href="{{ route('project::complete-step', $project->id) }}" id="complete-step" class="w-100 d-block invisible complete-btn">Complete Step</a>
                    @if (Auth::user()->can('skipWorkflow'))
                    <a href="#" data-toggle="modal" data-target="#skip-modal">Skip to...</a>
                    @endif
                    <hr>
                    <a href="#" class="w-100 d-block">Add Hold</a>
                    <a href="#" class="w-100 d-block">Remove Hold</a>
                </div>
                @endif
                @if (($project->workflow->step()->role && Auth::user()->hasRole($project->workflow->step()->role)))
                <h3 align="right" class="project-block-header">Checklist</h3>
                <div class="container-fluid border project-block" id="checklist-block">
                    @foreach ($project->workflow->step()->checklist as $task)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="{{ $loop->index }}" value="1" {{ (isset($task["status"]) && $task["status"]) ? " checked " : "" }} id="task{{ $loop->index }}">
                        <label class="form-check-label" for="task{{ $loop->index }}">
                            {{ (isset($task["task"])) ? $task["task"] : $task }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('project::complete-step', $project->id) }}" id="complete-step" class="btn btn-primary w-100 d-block invisible complete-btn">Complete Step</a>
                @endif
                <h3 align="right" class="project-block-header">Files</h3>
                <div class="container-fluid border project-block onedrive-files" style="padding: 0px">
                    @include("project.onedrive.view")
                </div>
                <div class="w-100 text-right"><a href="#">Upload File</a></div>
                <div class="w-100 text-right"><a href="file:///%USERPROFILE%/Stormcon LLC/Stormcon Portal - Documents/Projects/{{ $project->id }} - {{ $project->name }}/">Open in File Explorer</a></div>
                <h3 align="right" class="project-block-header">Notes</h3>
                <div class="container-fluid border project-block h-25 p-0">
                    @include("project.notes.view")
                </div>
                <div class="w-100 text-right"><a href="#" data-toggle="modal" data-target="#message-modal">Add Note</a></div>
            </div>
            <div class="col-9">
            @else
            <div class="col-12">
            @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#information" role="tab" aria-controls="home" aria-selected="true">Information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contractors" role="tab" aria-controls="contact" aria-selected="false">Contractors</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#site" role="tab" aria-controls="contact" aria-selected="false">Site</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#research" role="tab" aria-controls="contact" aria-selected="false">Research</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#bestpractices" role="tab" aria-controls="contact" aria-selected="false">BMPs</a>
                    </li>
                    <!--<li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#stabilization" role="tab" aria-controls="contact" aria-selected="false">Stabilization</a>
                    </li>-->
                    @if (isset($project->county))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#species" role="tab" aria-controls="contact" aria-selected="false">End. Species</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('viewInspections'))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="inspection-tab" data-toggle="tab" href="#inspections" role="tab" aria-controls="contact" aria-selected="false">Inspections</a>
                    </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="swppp-tab" data-toggle="tab" href="#swppp" role="tab" aria-controls="swppp" aria-selected="false">Export</a>
                    </li>
                </ul>
                {{ Form::open(array('route' => array('project::update', $project->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.information.view")
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contractors" role="tabpanel" aria-labelledby="contractors-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.contractors.view")
                        </div>
                    </div>
                    <div class="tab-pane fade" id="site" role="tabpanel" aria-labelledby="site-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.site.view")
                            @include("project.stabilizations.view")
                        </div>
                    </div>
                    <div class="tab-pane fade" id="research" role="tabpanel" aria-labelledby="research-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.research.view")
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bestpractices" role="tabpanel" aria-labelledby="bestpractices-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.bestpractices.view")
                        </div>
                    </div>
                    <div class="tab-pane fade" id="stabilization" role="tabpanel" aria-labelledby="stabilization-tab">
                        <div class="border border-top-0 p-5">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="species" role="tabpanel" aria-labelledby="species-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.endangeredspecies.view")
                        </div>
                    </div>
                    @if (Auth::user()->can('viewInspections'))
                    <div class="tab-pane fade" id="inspections" role="tabpanel" aria-labelledby="inspection-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.inspection.view")
                        </div>
                    </div>
                    @endif
                    <div class="tab-pane fade" id="swppp" role="tabpanel" aria-labelledby="swppp-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.swppp.view")
                        </div>
                    </div>
                </div>
                <div class="col-12 text-right mt-2">
                    <input type="submit" class="btn btn-primary w-25">
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal" id="skip-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Block Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select id="skip-step-option" class="form-control">
                        @foreach ($project->workflow->sub_items() as $step)
                            <option value="{{ $loop->index }}">{{ $step->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn save-skip btn-primary" data-dismiss="modal">Skip</button>
                </div>
            </div>
        </div>
    </div>
    <div class="quick-fill-btn" id="quick-fill-btn">+</div>
    <div class="quick-fill-select" style="display: none;" id="quick-fill-sel-div">
        <select id="quick-fill-sel" class="form-control">
            <option>Please select quick text</option>
            @foreach ($quicktext as $qt)
                <option value="{{ $qt->text }}">{{ $qt->name }}</option>
            @endforeach
        </select>
    </div>
@endsection

@section("scripts")
<script language="javascript" type="text/javascript">

    var contact_list = {!! $contacts->toJson() !!};


    $(".tab-content").on("change", ".company-select", function(e) {
        el = e.target;
        $.ajax({
            url: "/api/company/" + el.value,
            context: el,
            data: {
                'api_token': '{{ Auth::user()->api_token }}',
            },
            success: function(company) {

                let prefix = $(this).attr("id").substr(0, $(this).attr("id").lastIndexOf("_")+1);

                $("#" + prefix + "legal_name").val(company.legal_name);
                $("#" + prefix + "also_known_as").val(company.also_known_as);
                $("#" + prefix + "phone").val(company.phone);
                $("#" + prefix + "fax").val(company.fax);
                $("#" + prefix + "website").val(company.website);
                $("#" + prefix + "address").val(company.address);
                $("#" + prefix + "city").val(company.city);
                $("#" + prefix + "state").val(company.state);
                $("#" + prefix + "zipcode").val(company.zipcode);
                $("#" + prefix + "federal_tax_id").val(company.federal_tax_id);
                $("#" + prefix + "state_tax_id").val(company.state_tax_id);
                $("#" + prefix + "type").val(company.type);
                $("#" + prefix + "num_of_employees").val(company.num_of_employees);
                $("#" + prefix + "sos").val(company.sos);
                $("#" + prefix + "cn").val(company.cn);
                $("#" + prefix + "sic").val(company.sic);

                contacts = contact_list.filter(x => x.employer_id == company.id)

                $("#" + prefix + "contact_name_list").empty()
                $("[id^='" + prefix + "contact").val("");

                $.each(contacts, function(key, value) {
                    $("#" + prefix + "contact_name_list")
                        .append($("<option></option>")
                            .attr("value", value.first_name + " " + value.last_name)
                            .attr("id", value.id)
                            .text(value.first_name + " " + value.last_name));
                });

                noi_signers = contact_list.filter(x => x.employer_id == company.id && x.noi == "1")

                $("#" + prefix + "noi_signer_name_list").empty()
                $("." + prefix + "noi_signer_title").val("");

                $.each(noi_signers, function(key, value) {
                    $("#" + prefix + "noi_signer_name_list")
                        .append($("<option></option>")
                            .attr("value", value.first_name + " " + value.last_name)
                            .attr("id", value.id)
                            .text(value.first_name + " " + value.last_name));
                });

                not_signers = contact_list.filter(x => x.employer_id == company.id && x.noi == "1")

                $("#" + prefix + "not_signer_name_list").empty()
                $("." + prefix + "not_signer_title").val("");

                $.each(not_signers, function(key, value) {
                    $("#" + prefix + "not_signer_name_list")
                        .append($("<option></option>")
                            .attr("value", value.first_name + " " + value.last_name)
                            .attr("id", value.id)
                            .text(value.first_name + " " + value.last_name));
                });

            },
            error: function() {


                let prefix = $(this).attr("id").substr(0, $(this).attr("id").lastIndexOf("_")+1);

                $("#" + prefix + "legal_name").val("");
                $("#" + prefix + "also_known_as").val("");
                $("#" + prefix + "phone").val("");
                $("#" + prefix + "fax").val("");
                $("#" + prefix + "website").val("");
                $("#" + prefix + "address").val("");
                $("#" + prefix + "city").val("");
                $("#" + prefix + "state").val("");
                $("#" + prefix + "zipcode").val("");
                $("#" + prefix + "federal_tax_id").val("");
                $("#" + prefix + "state_tax_id").val("");
                $("#" + prefix + "type").val("");
                $("#" + prefix + "num_of_employees").val("");
                $("#" + prefix + "sos").val("");
                $("#" + prefix + "cn").val("");
                $("#" + prefix + "sic").val("");
            }

        })
    })


    //Page Load
    $(".company-select").each(function(index, item) {
        $(item).change();
    })

    $("#checklist-block").on("change", ".form-check-input", function(el) {

        anyUnchecked = false

        $(el.target).parents("div.project-block").find("input").each(function(idx, subel) {
           if (!subel.checked) anyUnchecked = true;
        })

        if (!anyUnchecked) $(".complete-btn").removeClass("invisible");
        if (anyUnchecked) $(".complete-btn").addClass("invisible");

    });

    $("#checklist-block input").on("click", function(el) {
        let item = el.target;
        let id = $(item).attr("id");
        let status = ( $(item).prop("checked") ) ? 1 : 0;

        $.ajax({
            url: "/api/projects/{{ $project->id }}/checklist/" + id + "/" + status,
            context: el,
            method: "get",
            data: {
                'api_token': '{{ Auth::user()->api_token }}',
            },
            error: function () {
                alert("Failed to update checklist");
            }
        });



    })

    @if (Auth::user()->can('skipWorkflow'))
    $(".save-skip").click(function() {
        step = $("#skip-step-option").val()
        $.ajax({
            url: "{{ route("project::skip-step", $project->id) }}",
            method: "GET",
            data: {
                'api_token': '{{ Auth::user()->api_token }}',
                'step': step,
            },
            success: function() {
                location.reload();
            },
            error: function() {
                alert("Could not skip step");
            }

        })
    })

    var lastdomobject;

    $(document).on("focusout", "input", function(e) {
        lastdomobject = e.currentTarget;
    })
    $(document).on("focusout", "textarea", function(e) {
        lastdomobject = e.currentTarget;
    })

    $(".quick-fill-btn").click(function(e) {
        $(".quick-fill-btn").fadeOut(400, function() {
            $(".quick-fill-select").fadeIn(400);
        })
        $("#quick-fill-sel").focus();
    })

    $(".quick-fill-select select").change(function(e) {
        old_str = $(lastdomobject).val()

        $(lastdomobject).val(old_str + $(".quick-fill-select select").val())
        $(".quick-fill-select").fadeOut(400, function() {
            $(".quick-fill-btn").fadeIn(400);
        })
        $(".quick-fill-select select").prop("selectedIndex", 0);
    })


    $(".quick-fill-select select").focusout(function() {
        $(".quick-fill-select").fadeOut(400, function () {
            $(".quick-fill-btn").fadeIn(400);
        })
        $(".quick-fill-select select").prop("selectedIndex", 0);
    })
    @endif
</script>
@endsection
