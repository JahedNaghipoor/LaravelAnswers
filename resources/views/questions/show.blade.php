@extends('template');

@section('content')
<div class="container">
<h1>{{ $question->title}}</h1>
<p class="lead">
{{ $question->description }}
</p>
<p>Submitted By: {{$question->user->name}}  on {{ $question->created_at->diffForHumans() }} </p>
<hr />
@if ($question->answers->count()> 0)
@foreach ($question->answers  as $key => $answer)
<div class="panel panel-default">
    <div class="panel-body">
        <h5>
        Answer {{ $key+1}} :  {{ $answer->content   }}
        </h5>
        <h6> Answered By: {{$answer->user->name}} on {{ $answer->created_at->diffForHumans() }}</h6>
            <hr />

    </div>
</div>
@endforeach
@else
<p>
    There is no answer to this question, please give an answer to this question
</p>
@endif

<form action=" {{ route('answers.store') }} " method="POST">
{{ csrf_field() }}

<h4> Submit Your Own Answer:</h4>
<textarea class="form-control" name="content" id="" cols="30" rows="4"></textarea>
<input type="hidden" value="{{ $question->id }} " name="question_id">
<button class="btn btn-primary">Submit Answer</button>
</form>
</div>

@endsection
