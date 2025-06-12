<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = auth()->user()->projects()->with('tasks');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $projects = $query->latest()->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = auth()->user()->projects()->create($request->validated());

        return redirect()->route('projects.show', $project)
                        ->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load(['tasks.assignedUser', 'user']);

        // Get tasks with pagination and filtering
        $query = $project->tasks()->with('assignedUser');

        // Apply status filter if provided
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Apply search filter if provided
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        $tasks = $query->latest()->paginate(10);

        return view('projects.show', compact('project', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
                        ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')
                        ->with('success', 'Projeto excluído com sucesso!');
    }
}
