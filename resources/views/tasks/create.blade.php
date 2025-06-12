<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Criar Nova Tarefa') }} - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.show', $project) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Voltar ao Projeto') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('projects.tasks.store', $project) }}">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Título da Tarefa')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                          :value="old('title')" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="4"
                                      class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                      placeholder="Descreva o que precisa ser feito...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>{{ __('Pendente') }}</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>{{ __('Em Progresso') }}</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>{{ __('Concluída') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Assigned To -->
                        <div class="mb-4">
                            <x-input-label for="assigned_to" :value="__('Atribuir a')" />
                            <select id="assigned_to" name="assigned_to"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">{{ __('Selecione um usuário (opcional)') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('projects.show', $project) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-3">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Criar Tarefa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
