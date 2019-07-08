@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go back</a>
    <h1>{{$post->title}}</h1>
    <div class="well">
        <img style="width: 100%" src="/storage/cover_images/{{ $post->cover_image }}">
        <br><br>
        {!! $post->body !!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}<br> by <strong>{{ $post->user->name }}</strong></small>

    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <hr>
            <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Éditer</a>

            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
            {!! Form::close() !!}
        @endif
    @endif
    <br><br>
@endsection