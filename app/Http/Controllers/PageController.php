<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Category;
use App\Mail\contactForm;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{

    public function template()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('_includes.nav.topnav')->with('categories', $categories);
    }

    public function profile($id)
    {
        $user = User::with(['questions', 'answers', 'answers.question'])->find($id);
        return view('profile')->with('user', $user);
    }

    public function subscribe($id)
    {
        $user = User::find($id);
        return view('subscribe')->with('user', $user);
    }

    public function recent()
    {
        $questions = Question::orderBy('id', 'DESC')->get()->take(5);
        return view('recent')->with('questions', $questions);
    }

    public function popular()
    {
        $answers = Answer::with('question')->get()->take(5)->sortBy(function ($answers) {
            return $answers->question->count();
        });
        // $answers = Answer::orderBy(Question::all()->count(), 'DESC')->get()->take(5);

        return view('popular')->with('answers', $answers);
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10'
        ]);

        Mail::to('jahednaghipoor1361@gmail.com')->send(new contactForm($request));

        return redirect('/');
    }
}
