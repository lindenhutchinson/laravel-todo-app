<?php
namespace App\Http\Controllers;

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
}