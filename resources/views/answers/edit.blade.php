@extends('template');

@section('content')
<div class="container">
    <form action="{{ route('answers.store') }}" method="POST">
        {{ csrf_field() }}
        <label for="title">Answer:</label>
    <textarea class="form-control" name="content" id="content" cols="30" rows="4">{{ $answer->content}}</textarea>
<input type="hidden" value="{{ $answer->question->id }} " name="question_id">
<input type="hidden" value="{{ $answer->id }} " name="answer_id">
<input type="submit" class="btn btn-primary" value="Submit Answer" />

    </form>
</div>

@endsection
