<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('projects.tasks.index', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Ver Todas as Tarefas') }}
                </a>
                <a href="{{ route('projects.tasks.create', $project) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Nova Tarefa') }}
                </a>
                <a href="{{ route('projects.edit', $project) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Editar Projeto') }}
                </a>
                <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Voltar') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Detalhes do Projeto') }}</h3>

                    @if($project->description)
                        <p class="text-gray-600 mb-4">{{ $project->description }}</p>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="font-semibold">{{ __('Criado em:') }}</span>
                            <span class="text-gray-600">{{ $project->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-semibold">{{ __('Total de Tarefas:') }}</span>
                            <span class="text-gray-600">{{ $project->total_tasks }}</span>
                        </div>
                        <div>
                            <span class="font-semibold">{{ __('Tarefas Concluídas:') }}</span>
                            <span class="text-gray-600">{{ $project->completed_tasks }}</span>
                        </div>
                    </div>

                    @if($project->total_tasks > 0)
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ ($project->completed_tasks / $project->total_tasks) * 100 }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ round(($project->completed_tasks / $project->total_tasks) * 100, 1) }}% concluído
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tasks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Tarefas') }}</h3>

                        <div class="flex gap-2">
                            <a href="{{ route('projects.tasks.create', $project) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                {{ __('+ Nova Tarefa') }}
                            </a>
                            <a href="{{ route('projects.tasks.index', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                {{ __('Ver Todas') }}
                            </a>
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('projects.show', $project) }}" class="flex gap-2">
                                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">{{ __('Todos os Status') }}</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pendente') }}</option>
                                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>{{ __('Em Progresso') }}</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('Concluída') }}</option>
                                </select>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Buscar tarefas..."
                                       class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Filtrar') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($tasks->count() > 0)
                        <div class="space-y-4">
                            @foreach($tasks as $task)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900">
                                                <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="hover:text-blue-600">
                                                    {{ $task->title }}
                                                </a>
                                            </h4>

                                            @if($task->description)
                                                <p class="text-gray-600 mt-2">{{ Str::limit($task->description, 150) }}</p>
                                            @endif

                                            <div class="flex items-center gap-4 mt-3 text-sm">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                      style="background-color: {{ $task->status_color }}; color: white;">
                                                    {{ $task->status_label }}
                                                </span>

                                                @if($task->assignedUser)
                                                    <span class="text-gray-600">
                                                        {{ __('Atribuída a:') }} {{ $task->assignedUser->name }}
                                                    </span>
                                                @endif

                                                <span class="text-gray-500">
                                                    {{ $task->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex gap-2 ml-4">
                                            <a href="{{ route('projects.tasks.show', [$project, $task]) }}"
                                               class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                {{ __('Ver') }}
                                            </a>
                                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                                               class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                {{ __('Editar') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">{{ __('Nenhuma tarefa encontrada.') }}</p>
                            <a href="{{ route('projects.tasks.create', $project) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Criar Primeira Tarefa') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
