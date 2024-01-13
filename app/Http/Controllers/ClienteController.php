<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $cliente;
    public function __construct(cliente $cliente) {
        $this->cliente = $cliente;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if($request->has('selectedAttributes')){
            $selectedAttributes = $request->selectedAttributes;
            $clienteRepository->selectAttributes($selectedAttributes);
        }else{
            $clienteRepository->selectRelatedAttributes('modelos');
        }
        if($request->has('modeloAttributes')){
            $modeloAttributes = 'modelos:id,'.$request->modeloAttributes;
            $clienteRepository->selectRelatedAttributes($modeloAttributes);
        }
        if($request->has('filter')){
            $clienteRepository->filter($request->filter);                
        }
        return response()->json($clienteRepository->getResults(), 200);
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
     * @param  \App\Http\Requests\StoreclienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules());

        $cliente = $this->cliente->create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
        ]);
        
        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = ['error' => 'inexistent parameter - try again'];

        $cliente = $this->cliente->with('modelos')->find($id);
        if($cliente === null){
            return response()->json($message, 404);
        }
        return response()->json($cliente, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateclienteRequest  $request
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = ['error' => 'parameter not found - try again'];
        
        $cliente = $this->cliente->find($id);
        if($cliente === null){
            return response()->json($message, 404);
        }

        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($cliente->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $dinamicRules[$input] = $rule;
                } 
                $request->validate($dinamicRules, $cliente->feedback());
            }
        }else{
            $request->validate($this->cliente->rules());
        }

        $cliente->fill($request->all());
        $cliente->save();

        return response()->json($cliente, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = ['success'=>'success delete',
                    'notfound'=>'delete route not found, inexistent index.',
                    'error'=>'error when deleting, try again'];

        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json($message['notfound'], 404);
        }

        if($cliente->delete()){
            return  response()->json($message['success'], 200);
        };
        return response()->json($message['error'], 408);
    }
}