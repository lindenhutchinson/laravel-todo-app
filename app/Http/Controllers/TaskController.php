<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Task;
use App\Http\Requests\TaskCreateRequest;



class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(TaskCreateRequest $request)
    {
        $validated = $request->validated();

        Task::create([
            'title' => $validated['title'],
            'completed' => false,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created!');
    }

    public function update(Request $request, Task $task)
    {
        // Ensure user owns the task
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    
        // Handle toggle (from index modal)
        if ($request->has('toggle')) {
            $task->completed = !$task->completed;
            $task->save();
    
            return redirect()->route('tasks.index')->with('success', 'Task status updated.');
        }
    
        // Handle full update (title)
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        $task->update([
            'title' => $request->input('title'),
        ]);
    
        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }
    
    public function destroy(Request $request, Task $task) {
        // Ensure user owns the task
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}