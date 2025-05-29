<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReuniaoPublicController extends Controller
{
    public function index()
    {
        $reunioes = Meeting::where('ativa', true)
            ->where('data_reuniao', '>=', now())
            ->orderBy('data_reuniao')
            ->paginate(9);

        return view('reunioes.index', compact('reunioes'));
    }

    public function show(Meeting $meeting)
    {
        $jaInscrito = false;
        if (Auth::check()) {
            $jaInscrito = Inscricao::where('user_id', Auth::id())
                ->where('reuniao_id', $meeting->id)
                ->exists();
        }

        // Contar inscrições
        $totalInscritos = Inscricao::where('reuniao_id', $meeting->id)->count();
        $vagasDisponiveis = $meeting->limite_participantes - $totalInscritos;

        return view('reunioes.show', compact('meeting', 'jaInscrito', 'totalInscritos', 'vagasDisponiveis'));
    }
}