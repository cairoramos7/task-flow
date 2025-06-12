<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $task->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Editar Tarefa') }}
                </a>
                <a href="{{ route('projects.show', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Voltar ao Projeto') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Task Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">{{ __('Detalhes da Tarefa') }}</h3>

                            @if($task->description)
                                <p class="text-gray-600 mb-4">{{ $task->description }}</p>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-semibold">{{ __('Status:') }}</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2"
                                          style="background-color: {{ $task->status_color }}; color: white;">
                                        {{ $task->status_label }}
                                    </span>
                                </div>

                                <div>
                                    <span class="font-semibold">{{ __('Projeto:') }}</span>
                                    <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-800 ml-2">
                                        {{ $project->name }}
                                    </a>
                                </div>

                                @if($task->assignedUser)
                                    <div>
                                        <span class="font-semibold">{{ __('Atribuída a:') }}</span>
                                        <span class="text-gray-600 ml-2">{{ $task->assignedUser->name }}</span>
                                    </div>
                                @endif

                                <div>
                                    <span class="font-semibold">{{ __('Criada em:') }}</span>
                                    <span class="text-gray-600 ml-2">{{ $task->created_at->format('d/m/Y H:i') }}</span>
                                </div>

                                @if($task->updated_at != $task->created_at)
                                    <div>
                                        <span class="font-semibold">{{ __('Atualizada em:') }}</span>
                                        <span class="text-gray-600 ml-2">{{ $task->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="ml-6">
                            <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Excluir Tarefa') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Comentários') }}</h3>

                    <!-- Add Comment Form -->
                    <form method="POST" action="{{ route('tasks.comments.store', $task) }}" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Adicionar Comentário')" />
                            <textarea id="content" name="content" rows="3"
                                      class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                      placeholder="Digite seu comentário..." required>{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Adicionar Comentário') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Comments List -->
                    @if($task->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($task->comments as $comment)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                                <span class="text-sm text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ $comment->content }}</p>
                                        </div>

                                        @if(auth()->id() === $comment->user_id)
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Tem certeza que deseja excluir este comentário?')"
                                                        class="text-red-600 hover:text-red-800 text-sm">
                                                    {{ __('Excluir') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">{{ __('Nenhum comentário ainda. Seja o primeiro a comentar!') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
