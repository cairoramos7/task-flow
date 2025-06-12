<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tarefas do Projeto: {{ $project->name }}
            </h2>
            <a href="{{ route('projects.tasks.create', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nova Tarefa
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Breadcrumb -->
                    <nav class="flex mb-6" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('projects.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    Projetos
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <a href="{{ route('projects.show', $project) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $project->name }}</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tarefas</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <!-- Filters -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('projects.tasks.index', $project) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Título ou descrição..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Todos os status</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Responsável</label>
                                <select name="assigned_to" id="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Todos os usuários</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Filtrar
                                </button>
                                <a href="{{ route('projects.tasks.index', $project) }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center">
                                    Limpar
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Tasks List -->
                    @if($tasks->count() > 0)
                        <div class="space-y-4">
                            @foreach($tasks as $task)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="hover:text-blue-600">
                                                    {{ $task->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 mb-3">{{ Str::limit($task->description, 150) }}</p>

                                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <span class="font-medium">Status:</span>
                                                    <span class="ml-1 px-2 py-1 rounded-full text-xs font-medium
                                                        @if($task->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                        @else bg-green-100 text-green-800
                                                        @endif">
                                                        {{ $statuses[$task->status] }}
                                                    </span>
                                                </div>

                                                @if($task->assignedUser)
                                                    <div class="flex items-center">
                                                        <span class="font-medium">Responsável:</span>
                                                        <span class="ml-1">{{ $task->assignedUser->name }}</span>
                                                    </div>
                                                @endif

                                                <div class="flex items-center">
                                                    <span class="font-medium">Criado em:</span>
                                                    <span class="ml-1">{{ $task->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex space-x-2 ml-4">
                                            <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Ver
                                            </a>
                                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $tasks->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 text-lg mb-4">
                                @if(request()->hasAny(['search', 'status', 'assigned_to']))
                                    Nenhuma tarefa encontrada com os filtros aplicados.
                                @else
                                    Nenhuma tarefa cadastrada neste projeto.
                                @endif
                            </div>
                            <a href="{{ route('projects.tasks.create', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Criar primeira tarefa
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
