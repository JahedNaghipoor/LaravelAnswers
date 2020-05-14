@extends('template')

@section('content')
<div class="container">
    @foreach ($results as $item)
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
    @endforeach
    @if (count($results) > 0)
    <div class="text-center">
        {{ $results->links() }}
    </div>
    @endif


</div>
@endsection
