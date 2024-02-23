<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'imagem',
    ];

    public function rules(){
        return [
            'nome' => 'required|unique:marcas', Rule::unique('nome')->ignore($this->id),
            'imagem' => 'required|file|mimes:png',
        ];
    }
    public function feedback(){
        return [
            'required' => 'O campo ":attribute" é obrigatório.',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG.',
            'imagem.file' => 'O campo ":attribute" é obrigatório.',
            'nome.unique' => 'O nome da marca já existe.',
        ];
    }

    public function modelos(){
        return $this->hasMany(Modelo::class);
    }
}
