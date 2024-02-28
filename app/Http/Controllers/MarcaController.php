<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    protected $marca;
    
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('selectedAttributes')){
            $selectedAttributes = $request->selectedAttributes;
            $marcaRepository->selectAttributes($selectedAttributes);
        }else{
            $marcaRepository->selectRelatedAttributes('modelos');
        }
        if($request->has('modeloAttributes')){
            $modeloAttributes = 'modelos:id,'.$request->modeloAttributes;
            $marcaRepository->selectRelatedAttributes($modeloAttributes);
        }
        if($request->has('filter')){
            $marcaRepository->filter($request->filter);                
        }
        return response()->json($marcaRepository->getPaginateResults(5), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $image = $request->file('imagem');
        $urn_image = $image->store('imagens/marcas', 'public');
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $urn_image,
        ]);
        
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = ['error' => 'inexistent parameter - try again'];

        $marca = $this->marca->with('modelos')->find($id);
        if($marca === null){
            return response()->json($message, 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = ['error' => 'parameter not found - try again'];
        
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json($message, 404);
        }

        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($marca->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $dinamicRules[$input] = $rule;
                } 
                $request->validate($dinamicRules, $marca->feedback());
            }
        }else{
            $request->validate($this->marca->rules(), $this->marca->feedback());
        }

        

        $marca->fill($request->all());
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);    
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/marcas', 'public');
            $marca->imagem = $imagem_urn;
        }
        $marca->save();
        // $image = $request->file('imagem');
        // $urn_image = $image->store('imagens/marcas', 'public');

        // $marca->fill($request->all());
        // $marca->imagem = $urn_image;
        // $marca->save();

        return response()->json($marca, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = ['success'=>'success delete',
                    'notfound'=>'delete route not found, inexistent index.',
                    'error'=>'error when deleting, try again'];

        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json($message['notfound'], 404);
        }

        Storage::disk('public')->delete($marca->imagem);

        if($marca->delete()){
            return  response()->json($message['success'], 200);
        };
        return response()->json($message['error'], 408);
    }
}
