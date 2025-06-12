<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Projetos') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Novo Projeto') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('projects.index') }}" class="mb-6">
                        <div class="flex gap-4">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Buscar projetos..."
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Buscar') }}
                            </button>
                            @if(request('search'))
                                <a href="{{ route('projects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    {{ __('Limpar') }}
                                </a>
                            @endif
                        </div>
                    </form>

                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($projects as $project)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                            {{ $project->name }}
                                        </a>
                                    </h3>

                                    @if($project->description)
                                        <p class="text-gray-600 mb-4 text-sm">
                                            {{ Str::limit($project->description, 100) }}
                                        </p>
                                    @endif

                                    <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                        <span>{{ $project->tasks_count }} tarefas</span>
                                        <span>{{ $project->created_at->format('d/m/Y') }}</span>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('projects.show', $project) }}"
                                           class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">
                                            {{ __('Ver') }}
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}"
                                           class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-1 px-3 rounded">
                                            {{ __('Editar') }}
                                        </a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Tem certeza que deseja excluir este projeto?')"
                                                    class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                {{ __('Excluir') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $projects->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">{{ __('Nenhum projeto encontrado.') }}</p>
                            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Criar Primeiro Projeto') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
