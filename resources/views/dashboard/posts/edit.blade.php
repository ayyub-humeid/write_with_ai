@extends('layouts.main')

@section('title', 'Edit Post')
@section('content')
    @include('dashboard.posts._form', [
        'post' => $post,
        'action' => route('dashboard.posts.update', $post->id),
        'method' => 'PUT',
    ])
@endsection
