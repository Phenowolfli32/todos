<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class TodoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->get();
        return view('todos.index', compact('tasks'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string|max:1000',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in-progress,done',
            'tags' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        \Log::info('Creating task for user: ' . Auth::id());

        Task::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {   
        \Log::info('Showing task - Task ID: ' . $task->id . ' | Task User ID: ' . $task->user_id . ' | Auth ID: ' . Auth::id() . ' | Auth User: ' . json_encode(Auth::user()));

        if ($task->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to access this task. Task ID: ' . $task->id . ' belongs to user ID: ' . $task->user_id . ', You are user ID: ' . Auth::id());
        }
        return view('todos.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to edit this task. Task belongs to user ID: ' . $task->user_id . ', You are user ID: ' . Auth::id());
        }
        return view('todos.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string|max:1000',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in-progress,done',
            'tags' => 'nullable|string|max:255',
        ]);

        $task->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $task->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $results = Task::where('user_id', Auth::id())
            ->where(function($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('tags', 'like', "%{$q}%");
            })
            ->get();

        return view('todos.search', compact('results', 'q'));
    }

    public function filterByPriority($priority)
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('priority', $priority)
            ->latest()
            ->get();

        return view('todos.index', compact('tasks'));
    }

    public function dueToday()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->whereDate('due_date', today())
            ->latest()
            ->get();

        return view('todos.index', compact('tasks'));
    }
}
