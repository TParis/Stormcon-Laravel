<div class="container">
    @if (isset($project->county) && $project->county)
    <h2 align="center">{{ $project->county->name }} County</h2>
    <h3 align="center"><a href="https://ipac.ecosphere.fws.gov/" target="_blank">Research Website</a></h3>
    <ul style="font-size: 14pt;">
    @foreach ($project->county->endangered_species as $species)
        <li>{{ $species->common_name }} (<i>{{ $species->scientific_name }}</i>)</li>
    @endforeach
    </ul>
    @endif
</div>
