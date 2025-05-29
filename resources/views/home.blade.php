@extends('layouts.public')
@section('title', 'Clube Literário - Início')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-12 mb-12">
    <div class="text-center">
        <h1 class="text-5xl font-bold mb-4">📚 Bem-vindo ao Clube Literário</h1>
        <p class="text-xl mb-8">Descubra, discuta e compartilhe o amor pela literatura</p>
        <a href="{{ route('reunioes.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            Ver Reuniões
        </a>
    </div>
</div>

<!-- Próximas Reuniões -->
<section class="mb-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Próximas Reuniões</h2>
    
    @if($proximasReunioes->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($proximasReunioes as $reuniao)
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
        
        <div class="text-center mt-8">
            <a href="{{ route('reunioes.index') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors">
                Ver Todas as Reuniões
            </a>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Nenhuma reunião agendada</h3>
            <p class="text-gray-500">Fique atento! Novas reuniões serão anunciadas em breve.</p>
        </div>
    @endif
</section>

<!-- Sobre o Clube -->
<section class="bg-white rounded-lg shadow-lg p-8">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Sobre o Clube Literário</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <div class="text-4xl mb-4">👥</div>
                <h3 class="text-xl font-semibold mb-2">Comunidade</h3>
                <p class="text-gray-600">Conecte-se com outros amantes da literatura e faça novos amigos que compartilham sua paixão pelos livros.</p>
            </div>
            <div>
                <div class="text-4xl mb-4">💬</div>
                <h3 class="text-xl font-semibold mb-2">Discussões</h3>
                <p class="text-gray-600">Participe de debates enriquecedores sobre diferentes gêneros literários e descubra novas perspectivas.</p>
            </div>
            <div>
                <div class="text-4xl mb-4">📖</div>
                <h3 class="text-xl font-semibold mb-2">Descobertas</h3>
                <p class="text-gray-600">Explore novos autores, gêneros e obras que expandirão seus horizontes literários.</p>
            </div>
        </div>
    </div>
</section>
@endsection