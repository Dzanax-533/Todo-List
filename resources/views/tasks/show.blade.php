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

                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
