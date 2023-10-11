@extends('Layout.mainLayout')
@section('body')
    <h1>Dashboard</h1>
    {{ auth()->user()->first_name }}
@endsection