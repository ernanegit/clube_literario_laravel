<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscricaoPublicController extends Controller
{
    public function store(Request $request, Meeting $meeting)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para se inscrever.');
        }

        $user = Auth::user();

        // Verificar se já está inscrito
        $jaInscrito = Inscricao::where('user_id', $user->id)
            ->where('reuniao_id', $meeting->id)
            ->exists();

        if ($jaInscrito) {
            return back()->with('error', 'Você já está inscrito nesta reunião.');
        }

        // Verificar vagas disponíveis
        $totalInscritos = Inscricao::where('reuniao_id', $meeting->id)->count();
        if ($totalInscritos >= $meeting->limite_participantes) {
            return back()->with('error', 'Não há mais vagas disponíveis.');
        }

        // Criar inscrição
        Inscricao::create([
            'user_id' => $user->id,
            'reuniao_id' => $meeting->id,
            'data_inscricao' => now(),
            'comentarios' => $request->comentarios,
            'confirmada' => false
        ]);

        return back()->with('success', 'Inscrição realizada com sucesso!');
    }

    public function minhas()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $inscricoes = Inscricao::where('user_id', Auth::id())
            ->with('reuniao')
            ->orderBy('data_inscricao', 'desc')
            ->paginate(10);

        return view('inscricoes.minhas', compact('inscricoes'));
    }
}