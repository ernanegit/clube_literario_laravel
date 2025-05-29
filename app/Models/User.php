<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'bio', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }

    public function reunioes()
    {
        return $this->belongsToMany(Reuniao::class, 'inscricoes')
                    ->withPivot('data_inscricao', 'comentarios', 'confirmada')
                    ->withTimestamps();
    }
}