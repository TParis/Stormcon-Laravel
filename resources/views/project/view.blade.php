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
                <div>Assigned: Unassigned</div>
                <h3 align="right" class="project-block-header">Actions</h3>
                <div class="container-fluid border project-block">
                    <a href="#" class="w-100 d-block">Add Blocker</a>
                    <a href="#" class="w-100 d-block">Clear Blocker</a>
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
                <h3 align="right" class="project-block-header">Files</h3>
                <div class="container-fluid border project-block">
                    <label class="form-check-label" for="taska">
                        <div><i class="fas fa-folder"></i> Maps</div>
                        <div><i class="fas fa-folder"></i> Folder</div>
                        <div><i class="fas fa-file"></i> Research.docx</div>
                        <div><i class="fas fa-file"></i> SWPPP.docx</div>
                    </label>
                </div>
                <div class="w-100 text-right"><a href="#">Upload File</a></div>
                <h3 align="right" class="project-block-header">Notes</h3>
                <div class="container-fluid border project-block h-25">
                </div>
                <div class="w-100 text-right"><a href="#">Add Note</a></div>
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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#stabilization" role="tab" aria-controls="contact" aria-selected="false">Stabilization</a>
                    </li>
                    @if (isset($project->county))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#species" role="tab" aria-controls="contact" aria-selected="false">End. Species</a>
                    </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="swppp-tab" data-toggle="tab" href="#swppp" role="tab" aria-controls="swppp" aria-selected="false">Export</a>
                    </li>
                </ul>
                @if ($project->id != "")
                {{ Form::open(array('route' => array('project::update', $project->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
                @else
                {{ Form::open(array('route' => array('project::create'), 'method' => 'post', 'class'	=> 'form-horizontal')) }}
                @endif
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

    $(".tab-content").on("change", ".company-select", function(e) {
        el = e.target;
        $.ajax({
            url: "/api/company/" + el.value,
            context: el,
            data: {
                'api_token': '{{ Auth::user()->api_token }}',
            },
            success: function(company) {
                let key = $(this).attr("id").substr(0, $(this).attr("id").lastIndexOf("_")+1);
                $("#" + key + "legal_name").val(company.legal_name);
                $("#" + key + "also_known_as").val(company.also_known_as);
                $("#" + key + "phone").val(company.phone);
                $("#" + key + "fax").val(company.fax);
                $("#" + key + "website").val(company.website);
                $("#" + key + "address").val(company.address);
                $("#" + key + "city").val(company.city);
                $("#" + key + "state").val(company.state);
                $("#" + key + "zipcode").val(company.zipcode);
                $("#" + key + "federal_tax_id").val(company.federal_tax_id);
                $("#" + key + "state_tax_id").val(company.state_tax_id);
                $("#" + key + "type").val(company.type);
                $("#" + key + "num_of_employees").val(company.num_of_employees);
                $("#" + key + "sos").val(company.sos);
                $("#" + key + "cn").val(company.cn);
                $("#" + key + "sic").val(company.sic);
            }

        })
    })

    $("#checklist-block").on("change", ".form-check-input", function(el) {

        anyUnchecked = false

        $(el).parent().children().each(function(subel) {
           if (!$(subel).checked) anyUnchecked = true;
        })

        if (!anyUnchecked) $("#complete-step").removeClass("invisible");

    });
</script>
@endsection
