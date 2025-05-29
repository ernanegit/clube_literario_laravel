@extends('layouts.public')

@section('title', $meeting->titulo . ' - Clube Literário')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header da Reunião -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        @if($meeting->imagem)
            <img src="{{ asset('storage/' . $meeting->imagem) }}" alt="{{ $meeting->titulo }}" class="w-full h-64 object-cover">
        @else
            <div class="w-full h-64 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                <span class="text-white text-8xl">📖</span>
            </div>
        @endif
        
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $meeting->titulo }}</h1>
            <p class="text-lg text-gray-600 mb-6">{{ $meeting->descricao }}</p>
            
            <!-- Informações da Reunião -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🎭</span>
                        <div>
                            <span class="font-semibold text-gray-700">Tema Literário:</span>
                            <p class="text-gray-600">{{ $meeting->tema_literario }}</p>
                        </div>
                    </div>
                    
                    @if($meeting->livro_sugerido)
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📚</span>
                            <div>
                                <span class="font-semibold text-gray-700">Livro Sugerido:</span>
                                <p class="text-gray-600">{{ $meeting->livro_sugerido }}</p>
                                @if($meeting->autor_livro)
                                    <p class="text-sm text-gray-500">por {{ $meeting->autor_livro }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">📅</span>
                        <div>
                            <span class="font-semibold text-gray-700">Data e Hora:</span>
                            <p class="text-gray-600">{{ $meeting->data_reuniao->format('d/m/Y \à\s H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">📍</span>
                        <div>
                            <span class="font-semibold text-gray-700">Local:</span>
                            <p class="text-gray-600">{{ $meeting->local }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">👥</span>
                        <div>
                            <span class="font-semibold text-gray-700">Participantes:</span>
                            <p class="text-gray-600">{{ $totalInscritos }}/{{ $meeting->limite_participantes }}</p>
                            <p class="text-sm text-gray-500">{{ $vagasDisponiveis }} vagas restantes</p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($meeting->observacoes)
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="font-semibold text-gray-700 mb-2">Observações:</h3>
                    <p class="text-gray-600">{{ $meeting->observacoes }}</p>
                </div>
            @endif
            
            <!-- Botão de Inscrição -->
            <div class="text-center">
                @auth
                    @if($jaInscrito)
                        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg">
                            <span class="font-semibold">✅ Você já está inscrito nesta reunião!</span>
                        </div>
                    @elseif($vagasDisponiveis <= 0)
                        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
                            <span class="font-semibold">❌ Não há mais vagas disponíveis</span>
                        </div>
                    @elseif($meeting->data_reuniao < now())
                        <div class="bg-gray-100 border border-gray-400 text-gray-700 px-6 py-4 rounded-lg">
                            <span class="font-semibold">⏰ Esta reunião já aconteceu</span>
                        </div>
                    @else
                        <form method="POST" action="{{ route('inscricoes.store', $meeting) }}" class="inline-block">
                            @csrf
                            <div class="mb-4">
                                <textarea name="comentarios" placeholder="Comentários (opcional)" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"></textarea>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600 transition-colors font-semibold text-lg">
                                🎯 Inscrever-se na Reunião
                            </button>
                        </form>
                    @endif
                @else
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <p class="text-blue-700 mb-4">Para se inscrever nesta reunião, você precisa estar logado.</p>
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Entrar
                            </a>
                            <a href="{{ route('register') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                Cadastrar
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Botão Voltar -->
    <div class="text-center">
        <a href="{{ route('reunioes.index') }}" class="text-blue-500 hover:text-blue-600 font-medium">
            ← Voltar para todas as reuniões
        </a>
    </div>
</div>
@endsection