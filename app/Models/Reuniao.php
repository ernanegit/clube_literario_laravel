<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniao extends Model
{
    use HasFactory;
    
    // Forçar o nome da tabela de forma mais agressiva
    protected $table = 'reunioes';
    
    public function __construct(array $attributes = [])
    {
        $this->table = 'reunioes';
        parent::__construct($attributes);
    }
    
    public function getTable()
    {
        return 'reunioes';
    }

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