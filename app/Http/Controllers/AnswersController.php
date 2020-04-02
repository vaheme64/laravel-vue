<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

    public function store(Question $question,Request $request)
    {
//        $request->answers()->create($request->validate([
//            'body'=>'required'
//        ]),['body'=>$request->body,'user_id'=>\Auth::id()]);
        $question->answers()->create($request->validate([
            'body'=>'required'
        ])+['user_id'=>\Auth::id()]);
        return back()->with('success','Your answer has been submitted successfully ');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);
        return view('answers.edit',compact('answer','question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question, Answer $answer)
    {
        $this->authorize('update',$answer);
        $answer->update($request->validate([
            'body'=>'required'
        ]));

        return redirect()->route('questions.show',$question->slug)->with('success','Your answer has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete',$answer);
        $answer->delete();
        return back()->with('success',"Your answered has been removed!");
    }
}
