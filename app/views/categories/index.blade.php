@extends('layouts.master')

@section('sidebar')
    @include('categories.navigation')
@stop

@section('heading')
    Category List
@stop

@section('content')
    <table class="table table-striped table-bordered">
        @include('categories.table-header')
        @foreach ($categories as $category)
            @include('categories.table-row', array('category' => $category))
        @endforeach
    </table>
@stop