<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $projects = $user->projects;

        return view("projects.index", ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        // Check if the user has permission to view this project
        if (! $project->users->contains(Auth::id())) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        // Validate the request data.
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $project = new Project;
        $project->name = $request->name;
        $project->description = $request->description;

        // Assign the project to the currently authenticated user
        $project->user_id = Auth::id();

        $project->save();

        // Attach the owner/editor role to the user for this project
        // TODO: Maybe add a owner role?
        Auth::user()->projects()->attach($project->id, ['role' => 'editor']);

        return redirect(route('projects.index'));
    }

    public function edit(Project $project)
    {
        // Check if the user has permission to edit this project
        $user = $project->users()->where('user_id', Auth::id())->first();

        if (!$user || !isset($user->pivot) || ($user->pivot->role !== 'owner' && $user->pivot->role !== 'editor')) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        // Check if the user has permission to edit this project
        $user = $project->users()->where('user_id', Auth::id())->first();

        if (!$user || !isset($user->pivot) || ($user->pivot->role !== 'owner' && $user->pivot->role !== 'editor')) {
            abort(403);
        }

        // Update the project
        $project->update($data);

        return redirect()->route('projects.show', $project);
    }

    public function createAssignment(Project $project)
    {
        // Show the form to assign a user to a project.
        $users = User::all();

        // Checking if the user has permissions to assign
        $user = $project->users()->where('user_id', Auth::id())->first();

        if (!$user || !isset($user->pivot) || ($user->pivot->role !== 'owner' && $user->pivot->role !== 'editor')) {
            abort(403);
        }

        return view('projects.assign', compact('users', 'project'));
    }

    public function storeAssignment(Request $request, Project $project)
    {
        // Validate the request data.
        $request->validate([
            'userId' => 'required',
            'role' => 'required',
        ]);

        $user = $project->users()->where('user_id', Auth::id())->first();

        if (!$user || !isset($user->pivot) || ($user->pivot->role !== 'owner' && $user->pivot->role !== 'editor')) {
            abort(403);
        }

        $project->users()->attach($request->userId, ['role' => $request->role]);

        return redirect(route('projects.index'));
    }
}
