<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    
    protected $table = 'reunioes';

    protected $fillable = [
        'titulo', 
        'descricao', 
        'tema_literario', 
        'livro_sugerido',
        'autor_livro', 
        'data_reuniao', 
        'local', 
        'limite_participantes',
        'ativa', 
        'observacoes',
        'imagem'
    ];

    protected $casts = [
        'data_reuniao' => 'datetime',
        'ativa' => 'boolean',
    ];
}