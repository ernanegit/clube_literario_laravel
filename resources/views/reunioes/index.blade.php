@extends('layouts.public')

@section('title', 'Todas as Reuniões - Clube Literário')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Todas as Reuniões</h1>
    <p class="text-gray-600">Explore todas as nossas reuniões literárias e encontre a perfeita para você</p>
</div>

@if($reunioes->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($reunioes as $reuniao)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                @if($reuniao->imagem)
                    <img src="{{ asset('storage/' . $reuniao->imagem) }}" alt="{{ $reuniao->titulo }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                        <span class="text-white text-6xl">📖</span>
                    </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $reuniao->titulo }}</h3>
                    <p class="text-gray-600 mb-3">{{ Str::limit($reuniao->descricao, 100) }}</p>
                    
                    <div class="space-y-2 text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <span class="mr-2">🎭</span>
                            <span>{{ $reuniao->tema_literario }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">📅</span>
                            <span>{{ $reuniao->data_reuniao->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">📍</span>
                            <span>{{ $reuniao->local }}</span>
                        </div>
                        @if($reuniao->livro_sugerido)
                            <div class="flex items-center">
                                <span class="mr-2">📚</span>
                                <span>{{ $reuniao->livro_sugerido }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center">
                        @php
                            $totalInscritos = \App\Models\Inscricao::where('reuniao_id', $reuniao->id)->count();
                            $vagas = $reuniao->limite_participantes - $totalInscritos;
                        @endphp
                        <span class="text-sm text-gray-500">
                            {{ $vagas }} vagas restantes
                        </span>
                        <a href="{{ route('reunioes.show', $reuniao) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $reunioes->links() }}
    </div>
@else
    <div class="text-center py-16">
        <div class="text-6xl mb-4">📚</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Nenhuma reunião disponível</h3>
        <p class="text-gray-500">Fique atento! Novas reuniões serão anunciadas em breve.</p>
    </div>
@endif
@endsection