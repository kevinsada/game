<?php

namespace App\Http\Controllers\Api;

use App\Events\FetchQuestion;
use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function fetchQuestion(Request $request)
    {
        $user = User::find($request->get('user_id'));

        $answeredQuestions = $user->questions()->pluck('id');

        $randomQuestion = Question::with('answers', 'category', 'difficulty')->whereNotIn('id', $answeredQuestions)->inRandomOrder()->first();

        broadcast(new FetchQuestion($user, $randomQuestion));

        return response()->json([
            'data' => $randomQuestion
        ]);
    }

    public function submit(Request $request)
    {
//        $user = User::find($request->get('user_id'));
//
//        $user->questions()->attach($request->question_id, ['answer_id' => $request->answer_id, 'is_correct' => $request->is_correct, 'points' => $request->points]);
//
//        $answeredQuestions = $user->questions()->pluck('id');
//
//        $randomQuestion = Question::with('answers', 'category', 'difficulty')->whereNotIn('id', $answeredQuestions)->inRandomOrder()->first();
//
//        broadcast(new FetchQuestion($user, $randomQuestion));

    }
}
