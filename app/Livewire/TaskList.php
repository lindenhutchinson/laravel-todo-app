<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskList extends Component
{
    public $tasks;
    public $taskToEdit;
    public $taskToDelete;
    public $newTitle;
    public $showEditModal = false;
    public $showDeleteModal = false;



    public function mount()
    {
        $this->fetchTasks();
    }

    public function fetchTasks()
    {
        $this->tasks = Auth::user()->tasks()->latest()->get();
    }
    

    public function toggleStatus($taskId)
    {
        $task = Task::findOrFail($taskId);
        if ($task->user_id !== Auth::id()) return;

        $task->completed = !$task->completed;
        $task->save();

        $this->fetchTasks();
    }
    
    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $this->taskToEdit = $task;
        $this->newTitle = $task->title;
        $this->showEditModal = true;
    }
    
    public function updateTask()
    {
        $this->taskToEdit->update(['title' => $this->newTitle]);
        $this->reset(['showEditModal', 'taskToEdit', 'newTitle']);
        $this->fetchTasks();
    }
    
    public function cancelEdit()
    {
        $this->reset(['showEditModal', 'taskToEdit', 'newTitle']);
    }
    
    public function confirmDelete($id)
    {
        $this->taskToDelete = $id;
        $this->showDeleteModal = true;
    }
    
    public function deleteTask()
    {
        Task::findOrFail($this->taskToDelete)->delete();
        $this->reset(['showDeleteModal', 'taskToDelete']);
        $this->fetchTasks();
    }
    
    public function cancelDelete()
    {
        $this->reset(['showDeleteModal', 'taskToDelete']);
    }    
}
