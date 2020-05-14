@extends('template');

@section('content')
<div class="container">
    <h1>{{ $question->title }}</h1>
    <p class="lead">
        {!! $question->description !!}
    </p>
    <p><img class="rounded-circle" src="{{ $question->user->profile_picture }}"
            style="max-height:30px;"> {{$question->user->name}} on {{ $question->created_at->diffForHumans() }} </p>
    <p>Category: {{$question->category->type}}</p>
    <a href="/upload/{{ $question->id}}">
        Download File
    </a>
    {{-- <img class="img-rounded pull-left" src="{{ $question->file }}" style="max-height:100px;"> --}}
    <br/>
    @if ($question->answers->count()> 0)
    @foreach ($question->answers as $key => $answer)
    <div class="card card-default">
        <div class="card-body">
            <h5>
                {!! $answer->content !!}
                @if ($answer->user->id === Auth::id())
                <a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-warning btn-sm">Edit Answer</a>
                <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete your answer?')"
                    href="{{route('answers.destroy', $answer->id)}}">Delete Answer</a>
                @endif
            </h5>
            <h6> <img class="rounded-circle" src="{{ $answer->user->profile_picture }}"
                    style="max-height:30px;"> {{$answer->user->name}} on {{ $answer->created_at->diffForHumans() }}</h6>

        </div>
    </div>
    @endforeach
    @else
    <p>
        There is no answer to this question, please give an answer to this question
    </p>
    @endif

    @section('scripts')
    <script>
        let app = new Vue({
    el: '#count',
    data: {
        viewers: [],
        count: 0
    },
    mounted() {
    this.listen();
    },
    methods:{
    listen(){

    Echo.join('questions.'+ '{{ $question->id}}')
    .here((users) => {
        this.count = users.length;
        this.viewers = users;
    })
    .joining( (user) => {
        this.count++;
        this.viewers.push(user);
    })
    .leaving((user) => {
        this.count--;
        -.pullAllBy(this.viewers, [user]);
    })
}
    }
    });
    </script>
    @endsection

    <form action=" {{ route('answers.store') }} " method="POST">
        {{ csrf_field() }}

        <h4> Submit Your Own Answer:</h4>
        <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
        <input type="hidden" value="{{ $question->id }} " name="question_id">
        <br />
        <button class="btn btn-primary">Submit Answer</button>
    </form>

    @if ( Auth::user()->isAdmin)
    <div class="alert alert-info" id="count">
        @{{count}} people are reading this topic right now.

        <ul>
            <li v-for="viewer in viewers">
                Id: @{{viewer.id}} - @{{viewer.name}}
            </li>
        </ul>
    </div>
    @endif

</div>

@endsection
