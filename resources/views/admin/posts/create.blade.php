@extends('layouts.admin')

@section('content')

    <h1 class="text-center">Create Posts</h1>

        <div class="row">

            {!!Form::open(['method'=>'POST','action'=>'AdminPostsController@store', 'files'=>true]) !!}

                <div class="form-group">
                    {!! Form::label('title','Title:') !!}
                    {!! Form::text('title',null,['class'=>'form-control'])!!}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id','Category:') !!}
                    {!! Form::select('category_id',array(1=>'Active',0=>'Not Active'),0,['class'=>'form-control'])!!}
                </div>

                <div class="form-group">
                    {!! Form::label('photo_id','Photo:') !!}
                    {!! Form::file('photo_id', array('multiple'=>true),['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('body','Description:') !!}
                    {!! Form::textarea('body',null,['class'=>'form-control','rows' => 7])!!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Create Post', ['class'=>'btn btn-primary']) !!}
                </div>

            {!! Form::close()!!}
        </div>

    <div class="row">

    @include('Includes.form_errors')

    </div>
@stop