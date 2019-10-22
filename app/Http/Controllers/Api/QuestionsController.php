<?php

namespace App\Http\Controllers\Api;

use App\Events\QuestionEvent;
use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuestionsController extends Controller
{

    public function randomQuestion($user) {
        $answeredQuestions = $user->questions()->pluck('id');

        return Question::with('answers', 'category', 'difficulty')->whereNotIn('id', $answeredQuestions)->inRandomOrder()->first();
    }

    public function fetchQuestion(Request $request)
    {
        Log::debug("fetchQuestion().. serverside");
        $user = User::find($request->user_id);

        $data = $this->randomQuestion($user);

        event(new QuestionEvent($user, $data));
    }

    public function submit(Request $request)
    {
        Log::debug("submit().. serverside");

        if ($request->count > 10) {
            return response()->json([
                'message' => 'You have finished the quiz'
            ]);
        }
        $user = User::find($request->get('user_id'));

        $user->questions()->attach($request->question_id, ['answer_id' => $request->answer_id, 'is_correct' => $request->is_correct, 'points' => $request->points]);

        $data = $this->randomQuestion($user);

        event(new QuestionEvent($user, $data));
    }
}
