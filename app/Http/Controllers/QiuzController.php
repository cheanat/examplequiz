<?php

namespace App\Http\Controllers;

use App\Models\Api\Quiz;
use Illuminate\Http\Request;

class QiuzController extends Controller
{
    public function index(){
        // $quizzes = Quiz::inRandomOrder()->take(10)->get();
        $quizzes = Quiz::get();

        return view('quiz.index',compact('quizzes'));
    }
    public function create(){
        return view('quiz.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'difficulty' => 'required|string',
            'category' => 'required|string',
            'question' => 'required|string',
            'correct_answer' => 'required|string',
            'incorrect_answers' => 'required|string',
            'category_id' => 'required|integer'
        ]);

        // Convert incorrect_answers to an array
        $incorrectAnswers = explode(',', $request->input('incorrect_answers'));
 // Set default values
 $type = 'multiple';  // Set your default value here
 $difficulty = 'medium';  // Set your default value here

        Quiz::create([
            'type' => $type,
            'difficulty' => $difficulty,
            'category' => $request->input('category'),
            'question' => $request->input('question'),
            'correct_answer' => $request->input('correct_answer'),
            'incorrect_answers' => $incorrectAnswers,
            'category_id' => $request->input('category_id')
        ]);

        return redirect()->route('quiz')->with('success', 'Quiz created successfully!');
    }
    public function edit(Quiz $quiz){
        return view('quiz.edit',compact('quiz'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'difficulty' => 'required|string',
            'category' => 'required|string',
            'question' => 'required|string',
            'correct_answer' => 'required|string',
            'incorrect_answers' => 'required|string',
            'category_id' => 'required|integer'
        ]);

        // Find the quiz and update
        $quiz = Quiz::findOrFail($id);

        // Convert incorrect_answers to an array
        $incorrectAnswers = explode(',', $request->input('incorrect_answers'));

        $quiz->update([
            'type' => $request->input('type'),
            'difficulty' => $request->input('difficulty'),
            'category' => $request->input('category'),
            'question' => $request->input('question'),
            'correct_answer' => $request->input('correct_answer'),
            'incorrect_answers' => $incorrectAnswers,
            'category_id' => $request->input('category_id')
        ]);

        return redirect()->route('quiz')->with('success', 'Quiz updated successfully!');
    }
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quiz')->with('success', 'Room deleted successfully.');
    }
}
