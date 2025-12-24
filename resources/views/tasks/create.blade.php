@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Tambah Tugas</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Tugas</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="is_completed" class="form-label">Status</label>
                        <select name="is_completed" class="form-control">
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (pisahkan dengan koma)</label>
                        <input type="text" name="tags" class="form-control" value="" placeholder="eg. pekerjaan, penting">
                        @if(isset($tags) && $tags->count())
                            <small class="form-text text-muted">Tag yang tersedia: {{ $tags->pluck('name')->join(', ') }}</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due date</label>
                        <input type="date" name="due_date" class="form-control" value="">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input" id="is_recurring">
                        <label class="form-check-label" for="is_recurring">Recurring</label>
                    </div>

                    <div class="mb-3">
                        <label for="recurrence" class="form-label">Recurrence</label>
                        <select name="recurrence" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
