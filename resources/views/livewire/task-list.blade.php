<div>
    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Your Tasks</h3>
        <a href="{{ route('tasks.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">Create Task</a>
    </div>

    <ul class="space-y-4">
        @forelse($tasks as $task)
            <li class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 rounded">
                <div>
                    <p class="text-lg font-semibold {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900 dark:text-white' }}">
                        {{ $task->title }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">
                        Status: {{ $task->completed ? 'Completed' : 'Pending' }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                            wire:click="toggleStatus({{ $task->id }})"
                            class="hidden"
                            {{ $task->completed ? '' : 'checked' }}>
                        <span class="w-5 h-5 flex items-center justify-center border-2 border-blue-500 rounded bg-white dark:bg-gray-800">
                            @if($task->completed)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </span>
                    </label>
                    <button
                        wire:click="editTask({{ $task->id }})"
                        class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-400">
                        Edit
                    </button>

                    <button
                        wire:click="confirmDelete({{ $task->id }})"
                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-500">
                        Delete
                    </button>
                </div>
            </li>
        @empty
            <li class="text-gray-500 dark:text-gray-300">No tasks yet.</li>
        @endforelse
    </ul>

    {{-- Edit Modal --}}
    @if($showEditModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white dark:bg-gray-800 rounded p-6 w-96">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Edit Task</h3>
                <input type="text" wire:model="newTitle" class="w-full px-4 py-2 border rounded mt-2" />
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="cancelEdit" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                    <button wire:click="updateTask" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white dark:bg-gray-800 rounded p-6 w-96">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Are you sure?</h3>
                <p class="mb-4 text-gray-700 dark:text-gray-300">Do you really want to delete this task?</p>
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="cancelDelete" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                    <button wire:click="deleteTask" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
