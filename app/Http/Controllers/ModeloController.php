<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Repositories\ModeloRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    protected $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $modeloRepository = new ModeloRepository($this->modelo);

        if($request->has('selectedAttributes')){
            $selectedAttributes = $request->selectedAttributes;
            $modeloRepository->selectAttributes($selectedAttributes);
        }else{
            $modeloRepository->selectRelatedAttributes('marca');
        }
        if($request->has('marcaAttributes')){
            $marcaAttributes = 'marca.id,'.$request->marcaAttributes;
            $modeloRepository->selectRelatedAttributes($marcaAttributes);
        }
        if($request->has('filter')){
            $modeloRepository->filter($request->filter);
        }
        return response()->json($modeloRepository->getResults(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate($this->modelo->rules());
        $image = $request->file('imagem');
        $urn_image = $image->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $urn_image,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'airbag' => $request->airbag,
            'abs' => $request->abs,
        ]);

        return response()->json($modelo, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $message = ['error' => 'inexistent parameter - try again'];

        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null){
            return response()->json($message, 404);
        }
        return response()->json($modelo, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $message = ['error' => 'parameter not found - try again'];
        $modelo = $this->modelo->find($id);
        if($modelo === null){
            return response()->json($message, 404);
        }

        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($modelo->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $dinamicRules[$input] = $rule;
                } 
                $request->validate($dinamicRules);
            }
        }else{
            $request->validate($this->modelo->rules());
        }

        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }

        $image = $request->file('imagem');
        $urn_image = $image->store('imagens/modelos', 'public');

        
        $modelo->fill($request->all());
        $modelo->imagem = $urn_image;
        $modelo->save();

        // $modelo->update([
        //     'marca_id' => $request->marca_id,
        //     'nome' => $request->nome,
        //     'imagem' => $urn_image,
        //     'numero_portas' => $request->numero_portas,
        //     'lugares' => $request->lugares,
        //     'airbag' => $request->airbag,
        //     'abs' => $request->abs,
        // ]);

        return response()->json($modelo, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $message = ['success'=>'success delete',
                    'notfound'=>'delete route not found, inexistent index.',
                    'error'=>'error when deleting, try again'];

        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return response()->json($message['notfound'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);

        if($modelo->delete()){
            return  response()->json($message['success'], 200);
        };
        return response()->json($message['error'], 408);
    }
}
