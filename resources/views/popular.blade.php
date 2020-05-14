@extends('template')

@section('content')
  <div class="container">

    <h2> 5 Popular Questions:</h2>

    @foreach ($answers as $answer)
    <div class="well">
        <h3>{{ $answer->question->title}}</h3>
        <p>
            {!! $answer->question->description !!}
        </p>
        <a href="{{ route('questions.show', $answer->question->id) }}" class="btn btn-primary btn-sm ">View Details</a>
    </div>
    <hr />
    @endforeach

  </div>
@endsection
