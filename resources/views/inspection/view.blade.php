<div class="containter-fluid">
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Inspector
        </div>
        <div class="col-6">
            @if (Auth::user()->hasAnyRole(['Inspector Supervisor', 'Admin', 'Sr Admin', 'Owner']))
                {{ Form::select('inspectors', $inspectors, $inspection->inspector->id, ['class' => 'form-control']) }}
            @else
                {{ $inspection->inspector->fullName }}
            @endif
        </div>
    </div>
    {{ Form::open(array('route' => array("inspection::complete", $inspection->id), 'method' => 'put', 'class'	=> 'form-horizontal')) }}
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Status
        </div>
        <div class="col-6">
            @if ($inspection->status == 1)
                Complete
            @elseif (Auth::user()->id == $inspection->inspector_id)
                {{ Form::submit("Mark Complete", ['class' => 'btn btn-primary']) }}
            @else
                Awaiting
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Ready to NOT
        </div>
        <div class="col-6">
            @if ($inspection->project->ready_to_not == 1)
                Ready
            @elseif (Auth::user()->id == $inspection->inspector_id)
                {{ Form::checkbox('rdy_to_not', 1, $inspection->project->rdy_to_not, ['class' => 'form-control']) }}
            @else
                Not Ready
            @endif
        </div>
    </div>
    @if ($inspection->project->not_complete())
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            NOT'd
        </div>
        <div class="col-6">
            @if (Auth::user()->id == $inspection->inspector_id)
                <button class="btn btn-primary">Mark Complete</button>
            @else
               Ready
            @endif
        </div>
    </div>
    @endif
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Project #
        </div>
        <div class="col-6">
            #{{ $inspection->project->proj_number}}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Project Name
        </div>
        <div class="col-6">
            {{ $inspection->project->name }}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Phase
        </div>
        <div class="col-6">
            {{ Form::select('phase', $inspection_phases, $inspection->project->phase, array('class' => 'text-right form-control')) }}
        </div>
    </div>
    {{ Form::close() }}
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Address
        </div>
        <div class="col-6">
            @if ($inspection->project->latitude && $inspection->project->longitude)
                <a href="https://www.google.com/maps/search/?api=1&query={{ $inspection->project->latitude }},{{ $inspection->project->longitude }}" target="_blank">{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}<br \>{{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}</a>
            @else
                        <a href="https://www.google.com/maps/place/{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}, {{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}" target="_blank">{{ $inspection->project->mailing_address_street_number }} {{ $inspection->project->mailing_address_street_name }}<br \>{{ $inspection->project->city }}, {{ $inspection->project->state }}, {{ $inspection->project->zipcode }}</a>
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Inspection Date
        </div>
        <div class="col-6">
            {{ $inspection->inspection_date }}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Inspection Format
        </div>
        <div class="col-6">
            {{ $inspection->project->inspection_format }}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Inspection Cycle
        </div>
        <div class="col-6">
            {{ ($inspection->project->inspection_cycle >= 30) ? "Monthly" : $inspection->project->inspection_cycle . " days" }}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6 font-weight-bold">
            Photo Uploads
        </div>
        <div class="col-6">

            @if (Auth::user()->need_token())
                <h2>Please login to the Microsoft API (allow popups)</h2>
            @else
                <form method="post" action="{{url('image/upload/store')}}" enctype="multipart/form-data"
                      class="dropzone onedrive w-100 dz-clickable" id="dropzone">
                    @csrf
                </form>
                <div class="d-md-none">
                    <input type="button" class="btn btn-secondary" id="upload-btn" value="Upload Photos" />
                </div>
            @endif

        </div>
    </div>
</div>


<script type="text/javascript">

    currentFolder = ""

    $("#onedrive").ready(function() {

        getDir("")
    });

    function getDir(dir = "") {
        $(".onedrive").html("")
        $.get({
            url: '{{ route("project::files", $inspection->project->id) }}',
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            data: {
                subdir: dir
            },
            success: function(data) {
                data.unshift({type: "dir", filename: "../"})

                data.sort(function(a, b) {

                    if (a.type == "dir" && b.type == "file") return -1;
                    var nameA = a.filename.toUpperCase();
                    var nameB = b.filename.toUpperCase();

                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }

                    // names must be equal
                    return 0;

                });

                $.each(data, function(key, el, e) {

                    if (el.type == "dir") {
                        $(".onedrive").append(makeDir(el))
                    } else {
                        $(".onedrive").append(makeFile(el))
                    }

                });

            }
        });

    };

    function makeDir(elem) {
        pic = $("<i>").addClass(["fas", "fa-folder", "col-1"]);
        text = $("<span class='change-folder col-11'>").data("folder", elem.filename).text(elem.filename)
        return $("<div>").append(pic).append(text)
    }

    function makeFile(elem) {
        pic = $("<i>").addClass(["fas", "fa-file", "col-1"]);
        link = $("<a>").attr("href", elem.link).addClass("col-11").attr("target", "_blank").text(elem.filename);
        return $("<div>").append(pic).append(link)
    }

    $(".onedrive").on("click", ".change-folder", function(e) {
        if ($(e.target).data("folder") != "../") {
            currentFolder = currentFolder + "/" + $(e.target).data("folder")
        } else {
            currentFolder = currentFolder.split("/").slice(0, currentFolder.split("/").length - 1).join('/')
        }

        getDir(currentFolder);
    })


    var myDropzone = new Dropzone("form#dropzone",
        {
            url: '{{ route('file::upload', $inspection->project->id) }}',
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            maxFilesize: 12,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.doc,.docx,.pdf,.msg,.txt",
            addRemoveLinks: true,
            clickable: "#upload-btn",
            timeout: 5000,
            sending: function(file, xhr, data) {
                data.append('subdir', currentFolder);
            },
            success: function(file, response)
            {
                console.log(response);
                getDir(currentFolder);
            },
            error: function(file, response)
            {
                return false;
            },
            complete: function(file) {
                this.removeFile(file);
            }
        });


    @if (Auth::user()->hasAnyRole(['Inspector Supervisor', 'Admin', 'Sr Admin', 'Owner']))

        $("select[name='inspectors']").change(function(el) {
            inspector_id = $(el.currentTarget).val();

            $.ajax({
                url: '{{ route('inspection::reassign', $inspection->id) }}',
                method: 'POST',
                data: {
                    'inspector_id': inspector_id,
                    'api_token': '{{ Auth::user()->api_token }}',
                },
                success: function() {
                    alert("Inspector Updated");
                    window.location.reload(true);
                },
                error: function() {
                    alert("Inspector update failed");
                }
            })
        });


    @endif

</script>
