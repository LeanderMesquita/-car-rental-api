<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarroController extends Controller
{
    protected $carro;
    public function __construct(Carro $carro) {
        $this->carro = $carro;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('selectedAttributes')){
            $selectedAttributes = $request->selectedAttributes;
            $carroRepository->selectAttributes($selectedAttributes);
        }else{
            $carroRepository->selectRelatedAttributes('modelos');
        }
        if($request->has('modeloAttributes')){
            $modeloAttributes = 'modelos:id,'.$request->modeloAttributes;
            $carroRepository->selectRelatedAttributes($modeloAttributes);
        }
        if($request->has('filter')){
            $carroRepository->filter($request->filter);                
        }
        return response()->json($carroRepository->getResults(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carro->rules());

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);
        
        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = ['error' => 'inexistent parameter - try again'];

        $carro = $this->carro->with('modelos')->find($id);
        if($carro === null){
            return response()->json($message, 404);
        }
        return response()->json($carro, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarroRequest  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = ['error' => 'parameter not found - try again'];
        
        $carro = $this->carro->find($id);
        if($carro === null){
            return response()->json($message, 404);
        }

        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($carro->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $dinamicRules[$input] = $rule;
                } 
                $request->validate($dinamicRules, $carro->feedback());
            }
        }else{
            $request->validate($this->carro->rules());
        }

        $carro->fill($request->all());
        $carro->save();

        return response()->json($carro, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = ['success'=>'success delete',
                    'notfound'=>'delete route not found, inexistent index.',
                    'error'=>'error when deleting, try again'];

        $carro = $this->carro->find($id);

        if($carro === null){
            return response()->json($message['notfound'], 404);
        }

        if($carro->delete()){
            return  response()->json($message['success'], 200);
        };
        return response()->json($message['error'], 408);
    }
}
