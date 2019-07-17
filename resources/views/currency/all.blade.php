@extends('app')

@section('content')
    @include('currency.table', ['currencies' => $currencies])
@endsection