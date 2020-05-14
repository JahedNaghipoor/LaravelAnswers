@extends('template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col md-12">
            <img class="img-rounded pull-right" src="{{ $user->profile_picture }}" style="max-height:100px;">
            <h2> {{ $user->name }}'s profile </h2>
            <form action=" {{ route('upload') }} " method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="picture" style="margin: 20px 0;" />
                <input type="submit" name="btn btn-primary" value="Upload" />
            </form>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-6">
            <h3>Questions ({{ $user->questions->count()}})</h3>
            @foreach ($user->questions as $key => $question)
            <div class="card card-default">
                <div class="card-body">
                    <h5 style="color: green">Created at {{ $question->created_at->diffForHumans() }}</h5>
                    {{-- <a href="{{ route('questions.show', $question->id) }} " class=" col-md-6 btn btn-link"> --}}
                        <h4 cl>{{ $question->title }}</h4>
                    {{-- </a> --}}
                    <p>{!! $question->description !!} </p>
                    <a href="{{ route('questions.show', $question->id) }}" class="btn btn-sm btn-link">
                        View Question </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <h3>Answers ({{ $user->answers->count()}})</h3>
            @foreach ($user->answers as $answer)
            <div class="card card-default">
                <div class="card-heading">
                    {{  $answer->question->title  }}
                </div>
                <div class="card-body">
                    <p style="color: green"> Asked at {{ $answer->question->created_at->diffForHumans() }} </p>
                    <p> {!! $answer->content !!} </p>
                    <p style="color: green">Answered at {{ $answer->created_at->diffForHumans() }} </p>
                    <a href="{{ route('questions.show', $answer->question->id) }} " class="btn btn-sm btn-link">
                        View All Answers for this Question </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
