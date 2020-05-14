<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller

{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search', 'searchjs']]);
    }


    public function search(Request $request)
    {
        if ($request->has('q')) {
            $request->flashOnly(('q'));
            $results = Question::search($request->q)->paginate(5);
        } else {
            $results = [];
        }
        return view('questions.search')->with('results', $results);
    }

    public function searchjs()
    {
        return view('questions.searchjs');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('id', 'desc')->paginate(4);
        return view('questions.index')->with('questions', $questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('questions.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);
        if (!$request->id) {
            $question = new Question();
        } else {
            $question = Question::find($request->id);
        }
        $question->title = $request->title;
        $question->description = $request->description;
        $question->user()->associate(Auth::id());
        $question->category_id = $request->category_selected;

        $file = $request->file('file');
        if ($file) {
            $filename = uniqid($question->id . "_", true) . "." . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($filename, File::get($file), 'public');
            $url = Storage::disk('s3')->url($filename);
            $question->file = $url;
        }

        if ($question->save()) {
            return redirect()->route('questions.show', $question->id);
        } else {
            return redirect()->route('questions.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('questions.show')->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        if ($question->user->id !== Auth::id()) {
            return abort(403);
        } else {
            $categories = Category::all();
            return view('questions.edit')->with(
                [
                    'question' => $question,
                    'categories' => $categories

                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->route('questions.index');
    }
}
