@extends('layouts.app')
@section('content')
    <div class="container">
        <question :user="{{Auth::user()}}"></question>
    </div>
@endsection
