<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;

class TaskController extends Controller
{
    // Menampilkan daftar tugas dengan pagination, pencarian, dan filter tag
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');
        $tag = $request->input('tag');

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
            ->withTag($tag)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $tags = Tag::orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'search', 'filter', 'tags', 'tag'));
    }

    // Menampilkan form tambah tugas
    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tasks.create', compact('tags'));
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
        ]);

        // Handle tags (comma-separated)
        $tagsInput = $request->input('tags');
        if ($tagsInput) {
            $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = Tag::findOrCreateByName($name);
                $tagIds[] = $tag->id;
            }
            $task->tags()->sync($tagIds);
        }

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
        $tags = Tag::orderBy('name')->get();
        return view('tasks.edit', compact('task', 'tags'));
    }

    // Mengupdate tugas (judul, deskripsi, status, dan tags)
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
        ]);

        $tagsInput = $request->input('tags');
        if ($tagsInput !== null) {
            $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = Tag::findOrCreateByName($name);
                $tagIds[] = $tag->id;
            }
            $task->tags()->sync($tagIds);
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menghapus tugas
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
