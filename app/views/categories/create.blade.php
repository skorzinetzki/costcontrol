@extends('layouts.master')

@section('sidebar')
    @include('categories.navigation')
@stop

@section('heading')
    Create new Category
@stop

@section('content')
    {{ Form::open(array('url' => 'categories', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form')) }}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            {{ Form::label('name', 'Category Name', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>
        {{ $errors->first('name', '<div class="form-group"><div class="col-sm-offset-4 col-sm-8"><span class="label label-danger">:message</span></div></div>') }}

        <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
            {{ Form::label('category_id', 'Choose Parent', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
                {{ Form::select('category_id', $category_options, null, array('class' => 'form-control')) }}
            </div>
        </div>
        {{ $errors->first('category_id', '<div class="form-group"><div class="col-sm-offset-4 col-sm-8"><span class="label label-danger">:message</span></div></div>') }}

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Submit</button>
              <a href="/categories" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancel</a>
            </div>
        </div>
    {{ Form::close() }}
@stop