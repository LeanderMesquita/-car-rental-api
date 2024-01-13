<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    protected $locacao;
    public function __construct(locacao $locacao) {
        $this->locacao = $locacao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        if($request->has('selectedAttributes')){
            $selectedAttributes = $request->selectedAttributes;
            $locacaoRepository->selectAttributes($selectedAttributes);
        }else{
            $locacaoRepository->selectRelatedAttributes('modelos');
        }
        if($request->has('modeloAttributes')){
            $modeloAttributes = 'modelos:id,'.$request->modeloAttributes;
            $locacaoRepository->selectRelatedAttributes($modeloAttributes);
        }
        if($request->has('filter')){
            $locacaoRepository->filter($request->filter);                
        }
        return response()->json($locacaoRepository->getResults(), 200);
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
     * @param  \App\Http\Requests\StorelocacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->locacao->rules());

        $locacao = $this->locacao->create([
            'cliente_id' => $request->cliente_id,
            'carro_id' => $request->carro_id,
            'data_inicio_periodo' => $request->data_inicio_periodo,
            'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
            'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
            'valor_diaria' => $request->valor_diaria,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final
        ]);
        
        return response()->json($locacao, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = ['error' => 'inexistent parameter - try again'];

        $locacao = $this->locacao->with('modelos')->find($id);
        if($locacao === null){
            return response()->json($message, 404);
        }
        return response()->json($locacao, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function edit(locacao $locacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelocacaoRequest  $request
     * @param  \App\Models\locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = ['error' => 'parameter not found - try again'];
        
        $locacao = $this->locacao->find($id);
        if($locacao === null){
            return response()->json($message, 404);
        }

        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($locacao->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $dinamicRules[$input] = $rule;
                } 
                $request->validate($dinamicRules, $locacao->feedback());
            }
        }else{
            $request->validate($this->locacao->rules());
        }

        $locacao->fill($request->all());
        $locacao->save();

        return response()->json($locacao, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = ['success'=>'success delete',
                    'notfound'=>'delete route not found, inexistent index.',
                    'error'=>'error when deleting, try again'];

        $locacao = $this->locacao->find($id);

        if($locacao === null){
            return response()->json($message['notfound'], 404);
        }

        if($locacao->delete()){
            return  response()->json($message['success'], 200);
        };
        return response()->json($message['error'], 408);
    }
}
