@extends('template')

@section('content')
  <div class="container">

    <div class="jumbotron">
      <h1>Ask a Question!</h1>
      <p>Ask any question you want to know and we will get the answers for you.</p>
      <p><a href="/questions/create" class="btn btn-primary btn-lg" role="button">Ask Now</a>
    </div>

    <h2>Recent Questions:</h2>

    {{-- @foreach ($questions as $question)
    <div class="well">
        <h3>{{ $question->title }}</h3>
        <p>
            {{ $question->description }}
        </p>
    </div>
    <hr />
    @endforeach --}}

  </div>
@endsection
