<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
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
        $due = $request->input('due'); // overdue, today, upcoming

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
            ->when($due, function ($query) use ($due) {
                $today = Carbon::today()->toDateString();
                if ($due === 'overdue') {
                    return $query->whereNotNull('due_date')->where('due_date', '<', $today);
                } elseif ($due === 'today') {
                    return $query->whereNotNull('due_date')->where('due_date', '=', $today);
                } elseif ($due === 'upcoming') {
                    return $query->whereNotNull('due_date')->where('due_date', '>', $today);
                }
            })
            ->withTag($tag)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $tags = Tag::orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'search', 'filter', 'tags', 'tag', 'due'));
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
            'due_date' => 'nullable|date',
            'is_recurring' => 'nullable|boolean',
            'recurrence' => 'nullable|in:daily,weekly,monthly',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
            'due_date' => $request->input('due_date'),
            'is_recurring' => (bool) $request->input('is_recurring'),
            'recurrence' => $request->input('recurrence'),
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
            'due_date' => 'nullable|date',
            'is_recurring' => 'nullable|boolean',
            'recurrence' => 'nullable|in:daily,weekly,monthly',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
            'due_date' => $request->input('due_date'),
            'is_recurring' => (bool) $request->input('is_recurring'),
            'recurrence' => $request->input('recurrence'),
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
