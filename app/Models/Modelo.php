<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Modelo extends Model
{
    use HasFactory;
    protected $table = 'modelos';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'marca_id',
        'nome',
        'imagem',
        'numero_portas',
        'lugares',
        'airbag',
        'abs',
    ];

    public function rules(){
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required', Rule::unique('nome')->ignore($this->id),
            'imagem' => 'required|file|mimes:png,jpeg,jpg',
            'numero_portas' => 'required|integer|max:4|min:2',
            'lugares' => 'required|integer|max:20|min:5',
            'airbag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'marca_id');
    }

}
