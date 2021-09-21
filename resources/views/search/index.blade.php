@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-6"><h3>Search Query: {{ $query }}</h3></div>
        <div class="col-6 text-right"><img src="{{ asset("images/search-by-algolia-light-background.png") }}"></div>
    </div>
    @foreach ($paginator as $result)
        @include("search." . $result["index"])
    @endforeach

    {{ $paginator->links() }}
@endsection
