@extends('template')

@section('content')
<!DOCTYPE html>
<html lang="en">
  <head>
  </head>
  <body>
    <div class="container">
      <h1>Ask a Questions</h1>
      <hr />
      <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label for="title">Category:</label>
        <div class="form-group row">
            <div class="col-sm-12">
                <select class="form-control" id="selectCategory" name="category_selected" required focus>
                    <option value="" disabled selected>Please select a category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{ $category->type }}</option>
                    @endforeach
                </select>
            </div>
            </div>
        <label for="title">Question:</label>
        <input type="text" name="title" id="title" class="form-control" />

        <label for="description">More Information:</label>
        <textarea class="form-control" name="description" id="description" rows="10"></textarea>
        <div class="row">
            <div class="col md-12">
                    <input type="file" name="file" style="margin: 20px 0;" />
            </div>
        </div>
<br />
    <input type="submit" class="btn btn-primary" value="Submit Question"/>
      </form>
    </div>
</body>
</html>
@endsection
