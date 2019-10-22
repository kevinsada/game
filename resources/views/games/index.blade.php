@extends('layouts.app')
{{--<h1 align="center">THE WEBSITE IS UNDER CONSTRUCTION</h1>--}}
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header align-self-sm-center align-content-center"
                         style="font-size: 22px; font-weight: bold">Multiple Choice Quiz
                    </div>
                    <div class="card">
                        <div class="card-body" style="font-size: 16px;">
                            <li style="list-style: circle">Your road map to the exciting exploration journey into the
                                fascinating world multiple
                                choices games. Here you can find thousands of tests in more than 20 different categories
                                and
                                3 different difficulties. Fun, personality, IQ tests, love and relationship, quizzes,
                                fan
                                tests - everything is possible on MultipleChoiceGame.com
                            </li>
                            <br>
                            <br>
                            <li style="list-style: circle">There are 10 questions in total. Each question is unique. On
                                top of each question will
                                be shown
                                the Category, Difficulty and Points corresponding to that question. Points from 1 to 3
                                are
                                shown corresponding on the question difficulty. Each question needs to be answered
                                within 60 seconds or will be counted as false.
                            </li>
                            <br>
                            <br>
                            <li style="list-style: circle"> What are you waiting for? Go ahead and try yourself!</li>

                        </div>
                    </div>
                    <a href="/quiz" class="btn btn-outline-secondary btn-block"
                       style="font-size:20px; font-weight:bold;">Start quiz</a>
                </div>
            </div>
        </div>

@stop
