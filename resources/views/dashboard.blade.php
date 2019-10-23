@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header align-self-sm-center" style="font-size: 22px; font-weight: bold">Dashboard
                    </div>

                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Question</td>
                            <td>Answer</td>
                            <td>Correct?</td>
                            <td>Difficulty</td>
                            <td>Points</td>
                        </tr>
                    </thead>
                    @foreach($results as $item)
                        <tbody>
                            <tr>
                                <td>{{ $item['question']->question }}</td>
                                <td>{{ $item['answer']->answer }}</td>
                                <td>{{ $item['answer']->is_correct }}</td>
                                <td>{{ $item['difficulty']->name }}</td>
                                <td>
                                    @if($item['answer']->is_correct)+@else - @endif

                                    @if($item['difficulty']->name == 'easy')1 @endif
                                    @if($item['difficulty']->name == 'medium')2 @endif
                                    @if($item['difficulty']->name == 'hard')3 @endif
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
@endsection
