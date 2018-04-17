@extends('layouts.default')
@section('title','主页')
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            你现在看到的是Laravle入门教程,一切将从这里开始
        </p>
        <p><a href="{{route('signup')}}" class="btn btn-primary">现在开始</a></p>
    </div>
@stop
