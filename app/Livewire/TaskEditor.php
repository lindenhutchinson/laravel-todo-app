<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskEditor extends Component
{
    public $taskId;
    public $title;
    public $completed = false;
    public $showModal = false;

    protected $listeners = ['editTask' => 'loadTask'];

    public function loadTask($taskId)
    {
        $task = Task::where('id', $taskId)->where('user_id', Auth::id())->firstOrFail();
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->completed = $task->completed;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = Task::findOrFail($this->taskId);
        if ($task->user_id !== Auth::id()) abort(403);

        $task->update([
            'title' => $this->title,
            'completed' => $this->completed,
        ]);

        $this->showModal = false;
        $this->emit('taskUpdated');
    }

    public function render()
    {
        return view('livewire.task-editor');
    }
}
