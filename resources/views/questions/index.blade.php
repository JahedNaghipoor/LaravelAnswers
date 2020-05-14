@extends('template')

@section('content')
<div class="container">
    <h1>All Questions:</h1>
    <hr />

    @foreach ($questions as $question)
    <div class="well">
        <h3>{{  $question->title  }}</h3>
        <p>
            {!!$question->description !!}
        </p>
        <p><img class="rounded-circle" src="{{ $question->user->profile_picture }}" style="max-height:30px;"> {{$question->user->name}} on {{ $question->created_at->diffForHumans() }}</p>
        <p>Category: {{$question->category->type}}</p>
        {{ $question->answers->count()>1 ? $question->answers->count() . ' Answers' : $question->answers->count() . ' Answer' }}
        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-primary btn-sm ">View Details</a>
        @if ($question->user->id === Auth::id())
        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm ">Edit Question</a>
        <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete your question? All related answers will be deleted too')"
            href="{{route('questions.destroy', $question->id)}}">Delete Question</a>
        @endif
    </div>
    <hr />
    @endforeach

    {{ $questions->links() }}
</div>
@endsection
