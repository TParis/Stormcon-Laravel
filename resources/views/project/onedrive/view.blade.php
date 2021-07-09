
@if (Auth::user()->need_token())
    <h2>Please login to the Microsoft API (allow popups)</h2>
@else
    <form method="post" action="{{url('image/upload/store')}}" enctype="multipart/form-data"
           class="dropzone onedrive w-100" id="dropzone">
    @csrf
    </form>
@endif

<script type="text/javascript">

    currentFolder = ""

    $("#onedrive").ready(function() {

        getDir("")
    });

    function getDir(dir = "") {
        $(".onedrive").html("")
        $.get({
            url: '{{ route("project::files", $project->id) }}',
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


    Dropzone.options.dropzone =
        {
            url: '{{ route('file::upload', $project->id) }}',
            headers: {'Authorization': 'Bearer {{ Auth::user()->api_token }}'},
            maxFilesize: 12,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.doc,.docx,.pdf,.msg,.txt",
            addRemoveLinks: true,
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
        };

</script>
