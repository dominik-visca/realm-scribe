<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($project->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ $project->description }}</p>

                    @php
                        $role = $project->users()->where('user_id', Auth::id())->first()->pivot->role;
                    @endphp

                    @if($role === 'owner' || $role === 'editor')
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Edit Project</a>
                    @endif

                    {{-- TODO Add owner role and remove the "editor" condition here --}}
                    @if($role === 'owner' || $role === 'editor')
                        <a href="{{ route('projects.createAssignment', $project) }}" class="btn btn-secondary">Assign User</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
