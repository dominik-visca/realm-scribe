<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('projects.update', $project) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Project Name:</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $project->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Project Description:</label>
                            <textarea id="description" class="form-control" name="description" required>{{ $project->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
