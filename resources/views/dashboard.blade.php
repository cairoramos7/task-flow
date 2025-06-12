<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">{{ __('Bem-vindo ao TaskFlow!') }}</h3>
                    <p class="text-gray-600">{{ __('Gerencie seus projetos e tarefas de forma eficiente.') }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ __('Projetos') }}</h4>
                                <p class="text-gray-600">{{ __('Visualize e gerencie seus projetos') }}</p>
                                <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    {{ __('Ver todos os projetos →') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ __('Novo Projeto') }}</h4>
                                <p class="text-gray-600">{{ __('Crie um novo projeto') }}</p>
                                <a href="{{ route('projects.create') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    {{ __('Criar projeto →') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ __('Perfil') }}</h4>
                                <p class="text-gray-600">{{ __('Gerencie suas informações') }}</p>
                                <a href="{{ route('profile.edit') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    {{ __('Editar perfil →') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Começar') }}</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                            <span>{{ __('Crie seu primeiro projeto para começar a organizar suas tarefas') }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                            <span>{{ __('Adicione tarefas aos seus projetos e acompanhe o progresso') }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                            <span>{{ __('Colabore com outros usuários atribuindo tarefas') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
