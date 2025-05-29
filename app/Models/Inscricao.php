<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;
    
    public $incrementing = true;
    public $timestamps = true;
    
    protected $table = 'inscricoes';

    // ADICIONAR ESTE MÉTODO
    public function getTable()
    {
        return 'inscricoes';
    }

    protected $fillable = [
        'user_id', 
        'reuniao_id', 
        'data_inscricao', 
        'comentarios', 
        'confirmada'
    ];

    protected $casts = [
        'data_inscricao' => 'datetime',
        'confirmada' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reuniao()
    {
        return $this->belongsTo(Reuniao::class);
    }
}