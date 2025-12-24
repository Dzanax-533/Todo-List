@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>{{ $task->title }}</h2>
            </div>
            <div class="card-body">
                <p>{{ $task->description }}</p>

                <p>
                    @foreach($task->tags as $tag)
                        <a href="{{ route('tasks.index', ['tag' => $tag->slug ?? $tag->name]) }}" class="badge bg-secondary text-decoration-none">{{ $tag->name }}</a>
                    @endforeach
                </p>

                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
