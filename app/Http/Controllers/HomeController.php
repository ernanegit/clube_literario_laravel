<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Buscar próximas 3 reuniões
        $proximasReunioes = Meeting::where('ativa', true)
            ->where('data_reuniao', '>=', now())
            ->orderBy('data_reuniao')
            ->limit(3)
            ->get();

        return view('home', compact('proximasReunioes'));
    }
}