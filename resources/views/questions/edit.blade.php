@extends('template');

@section('content')
<div class="container">
    <form action="{{ route('questions.store') }}" method="POST">
        {{ csrf_field() }}
        <label for="title">Category:</label>
        <div class="form-group row">
            <div class="col-sm-8">
                <select class="form-control" id="selectCategory" name="category_selected" required focus>
                    <option value="0">Please select a category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" @if ($category->id === $question->category->id) selected @endif>
                        {{ $category->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <label for="title">Question:</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $question->title}}" />
        <input name="id" type="hidden" value="{{ $question->id}}">

        <label for="description">More Information:</label>
        <textarea class="form-control" name="description" id="description"
            rows="10">  {{ $question->description }}</textarea>

        <input type="submit" class="btn btn-primary" value="Submit Question" />

    </form>
</div>

@endsection
