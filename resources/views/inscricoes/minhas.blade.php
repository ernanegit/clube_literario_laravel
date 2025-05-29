@extends('layouts.public')

@section('title', 'Minhas Inscrições - Clube Literário')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Minhas Inscrições</h1>
    <p class="text-gray-600">Acompanhe todas as suas inscrições em reuniões</p>
</div>

@if($inscricoes->count() > 0)
    <div class="space-y-6">
        @foreach($inscricoes as $inscricao)
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-start space-x-4">
                            @if($inscricao->reuniao && $inscricao->reuniao->imagem)
                                <img src="{{ asset('storage/' . $inscricao->reuniao->imagem) }}" 
                                     alt="{{ $inscricao->reuniao->titulo }}" 
                                     class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center rounded-lg">
                                    <span class="text-white text-2xl">📖</span>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                    {{ $inscricao->reuniao ? $inscricao->reuniao->titulo : 'Reunião removida' }}
                                </h3>
                                
                                @if($inscricao->reuniao)
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <span class="mr-2">🎭</span>
                                            <span>{{ $inscricao->reuniao->tema_literario }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="mr-2">📅</span>
                                            <span>{{ $inscricao->reuniao->data_reuniao->format('d/m/Y \à\s H:i') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="mr-2">📍</span>
                                            <span>{{ $inscricao->reuniao->local }}</span>
                                        </div>
                                        @if($inscricao->reuniao->livro_sugerido)
                                            <div class="flex items-center">
                                                <span class="mr-2">📚</span>
                                                <span>{{ $inscricao->reuniao->livro_sugerido }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="mt-3 flex items-center space-x-4">
                                    <span class="text-xs text-gray-500">
                                        Inscrito em {{ $inscricao->data_inscricao->format('d/m/Y H:i') }}
                                    </span>
                                    
                                    @if($inscricao->confirmada)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                            ✅ Confirmado
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                            ⏳ Pendente
                                        </span>
                                    @endif
                                    
                                    @if($inscricao->reuniao && $inscricao->reuniao->data_reuniao < now())
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                            🕒 Realizada
                                        </span>
                                    @elseif($inscricao->reuniao && $inscricao->reuniao->data_reuniao <= now()->addHours(24))
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            🔥 Próxima
                                        </span>
                                    @endif
                                </div>
                                
                                @if($inscricao->comentarios)
                                    <div class="mt-3 bg-gray-50 rounded p-3">
                                        <span class="text-xs text-gray-500 font-medium">Seus comentários:</span>
                                        <p class="text-sm text-gray-700 mt-1">{{ $inscricao->comentarios }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 md:mt-0 md:ml-6 flex flex-col space-y-2">
                        @if($inscricao->reuniao)
                            <a href="{{ route('reunioes.show', $inscricao->reuniao) }}" 
                               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-center text-sm">
                                Ver Reunião
                            </a>
                            
                            @if($inscricao->reuniao->data_reuniao > now())
                                <button onclick="cancelarInscricao({{ $inscricao->id }})" 
                                        class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors text-center text-sm">
                                    Cancelar
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $inscricoes->links() }}
    </div>
@else
    <div class="text-center py-16">
        <div class="text-6xl mb-4">📝</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Você ainda não tem inscrições</h3>
        <p class="text-gray-500 mb-6">Explore nossas reuniões e faça sua primeira inscrição!</p>
        <a href="{{ route('reunioes.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
            Ver Reuniões Disponíveis
        </a>
    </div>
@endif

<script>
function cancelarInscricao(id) {
    if (confirm('Tem certeza que deseja cancelar esta inscrição?')) {
        // Aqui você pode implementar a funcionalidade de cancelamento via AJAX
        alert('Funcionalidade de cancelamento será implementada em breve!');
    }
}
</script>
@endsection