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
        <div class="container workflow-timeline">
            @foreach ($project->workflow->sub_items() as $step)
                @if ($loop->index == $project->workflow->step)
                    <div class="workflow-item active">{{ $step->name }}</div>
                @else
                    <div class="workflow-item">{{ $step->name }}</div>
                @endif
            @endforeach
        </div>
        <h1>{{ $project->name }} #{{ $project->id }}</h1>
    @else
        <h1>Create Project</h1>
    @endif
    <div class="container-fluid projects">
        <div class="row">
            @if ($project->id != "")
            <div class="col-3">

                @include("project.assigned.view")
                @include("project.block.view")
                <strong>NOIs Signed:</strong><br />
                <strong>NOTs Signed:</strong>
                @if (Auth::user()->hasRole($project->workflow->step()->role) ||
                    Auth::user()->hasRole("Owner"))
                <h3 align="right" class="project-block-header">Actions</h3>
                <div class="container-fluid border project-block">
                    <a href="#" data-toggle="modal" data-target="#block-modal">Add Blocker</a>
                    <a href="#" class="w-100 d-block" id="save-unblock">Clear Blocker</a>
                    <hr>
                    <a href="#" class="w-100 d-block">Return to Previous Step</a>
                    <a href="{{ route('project::complete-step', $project->id) }}" id="complete-step" class="w-100 d-block invisible">Complete Step</a>
                    @if (Auth::user()->hasRole("Owner"))
                        <a href="#" class="w-100 d-block">Skip to...</a>
                    @endif
                    <hr>
                    <a href="#" class="w-100 d-block">Add Hold</a>
                    <a href="#" class="w-100 d-block">Remove Hold</a>
                </div>
                @endif
                @if (Auth::user()->hasRole($project->workflow->step()->role))
                <h3 align="right" class="project-block-header">To Do</h3>
                <div class="container-fluid border project-block" id="checklist-block">
                    @foreach (preg_split('/\r\n|\r|\n/', $project->workflow->step()->checklist) as $task)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="task{{ $loop->index }}">
                        <label class="form-check-label" for="task{{ $loop->index }}">
                            {{ $task }}
                        </label>
                    </div>
                    @endforeach
                </div>
                @endif
                <h3 align="right" class="project-block-header">Files</h3>
                <div class="container-fluid border project-block">
                    @include("project.onedrive.view")
                </div>
                <div class="w-100 text-right"><a href="#">Upload File</a></div>
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
                    @if (isset($project->county))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#species" role="tab" aria-controls="contact" aria-selected="false">End. Species</a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole(['Owner', 'Inspector Supervisor']))
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
                            @include("project.stabilizations.view")
                        </div>
                    </div>
                    <div class="tab-pane fade" id="species" role="tabpanel" aria-labelledby="species-tab">
                        <div class="border border-top-0 p-5">
                            @include("project.endangeredspecies.view")
                        </div>
                    </div>
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

                $("select[name='" + prefix + "contact_name']").empty()
                $("[id^='" + prefix + "contact']").val("");
                $("select[name='" + prefix + "contact_name']")
                    .append($("<option></option>")
                        .text("Please select"));

                $.each(contacts, function(key, value) {
                    $("select[name='" + prefix + "contact_name']")
                        .append($("<option></option>")
                            .attr("value", value.first_name + " " + value.last_name)
                            .attr("id", value.id)
                            .text(value.first_name + " " + value.last_name));
                });

                noi_signers = contact_list.filter(x => x.employer_id == company.id && x.noi == "1")

                $("select[name='" + prefix + "noi_signer_name']").empty()
                $("." + prefix + "noi_signer_title").val("");
                $("select[name='" + prefix + "noi_signer_name']")
                    .append($("<option></option>")
                        .text("Please select"));

                $.each(noi_signers, function(key, value) {
                    $("select[name='" + prefix + "noi_signer_name']")
                        .append($("<option></option>")
                            .attr("value", value.first_name + " " + value.last_name)
                            .attr("id", value.id)
                            .text(value.first_name + " " + value.last_name));
                });

            }

        })
    })

    $("#checklist-block").on("change", ".form-check-input", function(el) {

        anyUnchecked = false

        $(el.target).parents("div.project-block").find("input").each(function(idx, subel) {
           if (!subel.checked) anyUnchecked = true;
        })

        if (!anyUnchecked) $("#complete-step").removeClass("invisible");
        if (anyUnchecked) $("#complete-step").addClass("invisible");

    });
</script>
@endsection
