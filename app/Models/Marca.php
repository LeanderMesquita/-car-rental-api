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
            'nome' => 'required', Rule::unique('nome')->ignore($this->id),
            'imagem' => 'required|file|mimes:png',
        ];
    }
    public function feedback(){
        return [
            'required' => 'the :attribute is required.',
            'nome.unique' => 'the name already exists.'
        ];
    }

    public function modelos(){
        return $this->hasMany(Modelo::class);
    }
}
