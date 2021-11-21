<div class="container">
    @if (isset($project->county) && $project->county)
    <h2 align="center">{{ $project->county->name }} County</h2>
    <h3 align="center"><a href="https://tpwd.texas.gov/ris.net/rtest/" target="_blank">Research Website</a></h3>
    <ul style="font-size: 14pt;">
    @foreach ($project->county->endangered_species as $species)
        <li>{{ $species->common_name }}</li>
    @endforeach
    </ul>
    @endif
</div>
