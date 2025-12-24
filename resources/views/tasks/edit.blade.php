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

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ optional($task->due_date)->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input" id="is_recurring" {{ $task->is_recurring ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_recurring">Recurring</label>
                    </div>

                    <div class="mb-3">
                        <label for="recurrence" class="form-label">Recurrence</label>
                        <select name="recurrence" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="daily" {{ $task->recurrence === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $task->recurrence === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $task->recurrence === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
