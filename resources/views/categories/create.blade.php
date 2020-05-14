@extends('template')

@section('content')

<div class="container">

    <h2> Add Category:</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        {{ csrf_field() }}
        <label for="type">Category:</label>
        <input type="text" name="type" id="type" class="form-control" />
<br />
        <input type="submit" class="btn btn-primary" value="Add Category" />

    </form>
    <hr />
    <div class="col md6">
        <h3>Categories:</h3>
        @foreach ($categories as $category)
        <li> {{ $category->type }} </li>
        @endforeach
    </div>
</div>

@endsection
