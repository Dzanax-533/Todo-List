@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Daftar Tugas</h2>
            </div>
            <div class="card-body">
                <!-- Form Pencarian & Filter -->
                <form action="{{ route('tasks.index') }}" method="GET" class="mb-3 d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari tugas..."
                        value="{{ request('search') }}">

                    <select name="filter" class="form-control me-2">
                        <option value="">Semua</option>
                        <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Belum Selesai
                        </option>
                    </select>

                    <select name="tag" class="form-control me-2">
                        <option value="">Semua Tag</option>
                        @if(isset($tags))
                            @foreach($tags as $t)
                                <option value="{{ $t->slug ?? $t->name }}" {{ request('tag') == ($t->slug ?? $t->name) ? 'selected' : '' }}>{{ $t->name }}</option>
                            @endforeach
                        @endif
                    </select>

                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>

                <!-- Tombol Tambah -->
                <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">Tambah Tugas</a>

                <!-- Tabel -->
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Tags</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>
                                    @foreach($task->tags as $tag)
                                        <a href="{{ route('tasks.index', array_merge(request()->all(), ['tag' => $tag->slug ?? $tag->name])) }}" class="badge bg-secondary text-decoration-none">{{ $tag->name }}</a>
                                    @endforeach
                                </td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @if ($task->is_completed)
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning">Belum Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
