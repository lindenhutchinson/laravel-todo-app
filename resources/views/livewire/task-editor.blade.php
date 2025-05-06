@if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Edit Task</h2>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" wire:model="title"
                       class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white mt-1" />
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="completed"
                           class="rounded border-gray-300 dark:border-gray-600 text-indigo-600">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Completed</span>
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <button wire:click="$set('showModal', false)"
                        class="px-3 py-1 text-sm bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>
                <button wire:click="save"
                        class="px-3 py-1 text-sm bg-indigo-600 text-white rounded">Save</button>
            </div>
        </div>
    </div>
@endif
