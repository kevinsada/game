<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Category;
use App\Difficulty;
use App\Http\Controllers\Auth\RegisterController;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\FetchQuestion;

class QuestionController extends Controller
{
    public function fetchQuestions()
    {
        $data = json_decode(file_get_contents('https://opentdb.com/api.php?amount=100&type=multiple'), true);
        $results = $data['results'];
        foreach ($results as $result) {
            $question = Question::where('question', $result['question'])->first();
            if (!$question) {
                $category = Category::firstOrCreate([
                    'name' => $result['category']
                ]);

                $difficulty = Difficulty::firstOrCreate([
                    'name' => $result['difficulty']
                ]);

                $question = Question::create([
                    'question' => $result['question'],
                    'category_id' => $category->id,
                    'difficulty_id' => $difficulty->id,
                ]);

                Answer::create([
                    'answer' => $result['correct_answer'],
                    'is_correct' => true,
                    'question_id' => $question->id,
                ]);

                foreach ($result['incorrect_answers'] as $incorrect_answer) {
                     Answer::create([
                        'answer' => $incorrect_answer,
                        'is_correct' => false,
                        'question_id' => $question->id,
                    ]);
                }
            }
        }
    }

    public function show()
    {
        $user = Auth::user();
        $answeredQuestions = $user->questions()->pluck('id');

        $randomQuestion = Question::with('answers')->whereNotIn('id', $answeredQuestions)->inRandomOrder()->first();

//        event(new FetchQuestion(Auth::user(), 'HI I AM A MESSAGE FROM THE SERVER'));
        dd($randomQuestion);
    }
}
