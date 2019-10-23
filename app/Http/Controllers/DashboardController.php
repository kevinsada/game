<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Answer;
use App\Category;
use App\Difficulty;


class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $user = User::find($userId);

        $data = [];

        foreach($user->questions as $question) {
            $temp = [];
            $temp['question'] = $question;
            $temp['answer'] = Answer::where('question_id', $question->id)->first();
            $temp['difficulty'] = Difficulty::where('id', $question->difficulty_id)->first();

            $data[$question->id] = $temp;
        }

        return view('dashboard')->with(
            ['results' => $data]
        );
    }
}
