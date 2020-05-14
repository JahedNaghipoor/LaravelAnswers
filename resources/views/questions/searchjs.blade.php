@extends('template')

@section('content')
<div class="container">
    <ais-index app-id=" {{ config('scout.algolia.id') }} " api-key="{{ env('ALGOLIA_SEARCH')}}" index-name="questions">
        <h1>Search Questions:</h1>
        <ais-input placeholder="Search for a post..."></ais-input>
        <hr />

        <ais-results></ais-results>
        {{--  @foreach ($results as $item)
    <div class="row" style="top-margin:20px">
        <div class="col-md-12">
            <a href=" {{ route('questions.show', $item->id) }} ">
        <h3>{{$item->title}}</h3>
        </a>
</div>

<div class="col-md-12">
    <p>
        {{ $item->description}}
    </p>
</div>
</div>
@endforeach --}}

</ais-index>
</div>
@endsection
