<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'email',
    ];
    public function rules() {
        return [
            'nome' => 'required',
            'cpf' => 'required|string',
            'email' => 'required',
        ];
    }
    
}
