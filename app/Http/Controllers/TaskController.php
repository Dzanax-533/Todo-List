<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Menampilkan daftar tugas dengan pagination dan pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');

        $tasks = Task::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%$search%");
            })
            ->when($filter, function ($query) use ($filter) {
                if ($filter === 'completed') {
                    return $query->where('is_completed', true);
                } elseif ($filter === 'pending') {
                    return $query->where('is_completed', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('tasks.index', compact('tasks', 'search', 'filter'));
    }

    // Menampilkan form tambah tugas
    public function create()
    {
        return view('tasks.create');
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    // Menampilkan detail tugas
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Menampilkan form edit tugas
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Mengupdate tugas (judul, deskripsi, dan status)
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menghapus tugas
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
