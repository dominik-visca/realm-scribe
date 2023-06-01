<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Create Project</a>

                    @forelse ($projects as $project)
                        <div class="project">
                            <h2>{{ $project->name }}</h2>
                            <p>{{ $project->description }}</p>
                            <p>Role: {{ $project->pivot->role }}</p>
                        </div>
                    @empty
                        <p>You have no projects.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
