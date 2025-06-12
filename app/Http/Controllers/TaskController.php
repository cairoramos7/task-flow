<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project, Request $request): View
    {
        $this->authorize('view', $project);

        $query = $project->tasks()->with(['assignedUser', 'project']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $query->latest()->paginate(10);
        $users = User::all();
        $statuses = Task::getStatuses();

        return view('tasks.index', compact('project', 'tasks', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project): View
    {
        $this->authorize('view', $project);

        $users = User::all();
        $statuses = Task::getStatuses();

        return view('tasks.create', compact('project', 'users', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('view', $project);

        $task = $project->tasks()->create($request->validated());

        return redirect()->route('projects.tasks.show', [$project, $task])
                        ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task): View
    {
        $this->authorize('view', $project);

        $task->load(['assignedUser', 'comments.user']);

        return view('tasks.show', compact('project', 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task): View
    {
        $this->authorize('view', $project);

        $users = User::all();
        $statuses = Task::getStatuses();

        return view('tasks.edit', compact('project', 'task', 'users', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $this->authorize('view', $project);

        $task->update($request->validated());

        return redirect()->route('projects.tasks.show', [$project, $task])
                        ->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task): RedirectResponse
    {
        $this->authorize('view', $project);

        $task->delete();

        return redirect()->route('projects.tasks.index', $project)
                        ->with('success', 'Tarefa excluída com sucesso!');
    }
}
