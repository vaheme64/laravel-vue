<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index()
    {
//        \DB::enableQueryLog();
        $questions=Question::with('user')->latest()->paginate(5);
//        view('questions.index',compact('questions'))->render();
        return view('questions.index',compact('questions'));
//        dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question=new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
//        $this->user()->questions()->create($request->all());
        $request->user()->questions()->create($request->only('title','body'));
        return redirect()->route('questions.index')->with('success','Question is Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show',compact('question'));
        //agar khodemon mikhastim dorost konim route ba slug, bayad slug be show midadim , va bad , dar
        //jadaval peida mikardim va bad neshon midadim
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
//        if(\Gate::allows('update-question',$question)){
//            return view('questions.edit',compact('question'));
//        }
//        abort(403,'Access Denied!');

        if(\Gate::denies('update-question',$question)){
            abort(403,'Access Denied!');
        }
        return view('questions.edit',compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title','body'));
        return redirect('/questions')->with('success','update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect('/questions')->with('success','Your question deleted');
    }
}
