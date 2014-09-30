@extends('layouts.master')

@section('sidebar')
    @include('categories.navigation')
@stop

@section('heading')
    Category Details
@stop

@section('content')
    @if ($category->hasSuperiorCategory())
        <h2>{{ $category->name }} <small>(in {{ link_to('/categories/' . $category->superiorCategory->id, $category->superiorCategory->name) }})</small></h2>
    @else
        <h2>{{ $category->name }}</h2>
    @endif

    @if ($category->subordinateCategories->count() > 0)
        <h3>Subordinate Categories of {{ $category->name }}</h3>

        <table class="table table-striped table-bordered">
            @include('categories.table-header')
            @foreach ($category->subordinateCategories as $subordinateCategory)
                @include('categories.table-row', array('category' => $subordinateCategory))
            @endforeach
        </table>
    @endif
@stop