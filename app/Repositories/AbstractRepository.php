<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository{
    
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectRelatedAttributes($attributes){
        $this->model->with($attributes);
    }
    public function filter($raw_filters){
        $filters = explode('/', $raw_filters);

        foreach($filters as $key => $condition){
            $conditions_pile = explode(':', $condition);
            $this->model = $this->model->where($conditions_pile[0],$conditions_pile[1],$conditions_pile[2]);
        }
    }
    public function selectAttributes($attributes){
        $this->model = $this->model->selectRaw($attributes);
    }
    public function getResults(){
        return $this->model->get();
    }
    public function getPaginateResults($number_of_registers){
        return $this->model->paginate($number_of_registers);
    }
}
?>