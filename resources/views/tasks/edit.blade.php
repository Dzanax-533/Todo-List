@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Edit Tugas</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Tugas</label>
                        <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control">{{ $task->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="is_completed" class="form-label">Status</label>
                        <select name="is_completed" class="form-control">
                            <option value="0" {{ !$task->is_completed ? 'selected' : '' }}>Belum Selesai</option>
                            <option value="1" {{ $task->is_completed ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (pisahkan dengan koma)</label>
                        <input type="text" name="tags" class="form-control" value="{{ $task->tags->pluck('name')->join(', ') }}" placeholder="eg. pekerjaan, penting">
                        @if(isset($tags) && $tags->count())
                            <small class="form-text text-muted">Tag yang tersedia: {{ $tags->pluck('name')->join(', ') }}</small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
