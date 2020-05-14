<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Notifications\NewAswerSubmitted;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            'content' => 'required|min:15',
            'question_id'=> 'required|integer'
        ]);
        if (!$request->answer_id) {
            $answer = new Answer();
        } else {
            $answer = Answer::find($request->answer_id);
        }
        $answer->content = $request->content;
        $answer->user()->associate(Auth::id());
        $question = Question::findOrFail($request->question_id);
        $question->answers()->save($answer);

        $question->user->notify(new NewAswerSubmitted($answer, $question, Auth::user()->name));

        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::findOrFail($id);

        if ($answer->user->id !== Auth::id()) {
            return abort(403);
        } else {
            return view('answers.edit')->with('answer', $answer);
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
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return redirect()->route('questions.show', $answer->question->id);
    }
}
