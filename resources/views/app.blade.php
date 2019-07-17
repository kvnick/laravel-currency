@extends('layout.master')

@section('title', 'AdminLTE 2 | Welcome to Laravel')

@section('header')
    @parent
    <link rel="stylesheet" href="/css/app.css">
@endsection

@section('main_menu')
    @include('layout.header')
@endsection

@section('content')
    <h1>Lorem ipsum.</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto odio ut, minus. Quisquam neque ut nostrum asperiores soluta. Quos, nobis. </p>
@endsection

@section('footer')
    @include('layout.footer')
@endsection

@section('footer_scripts')
    @parent
@endsection

