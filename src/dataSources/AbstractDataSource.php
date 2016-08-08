<?php
namespace Endouble\TheVacancyRepositoryProblem\dataSources;
use Endouble\TheVacancyRepositoryProblem\models\Model;
use Endouble\TheVacancyRepositoryProblem\gateways\Gateway;
use Endouble\TheVacancyRepositoryProblem\factories\Factory;

abstract class AbstractDataSource implements DataSource
{
    protected $gateway = null;
    protected $factory = null;
    protected $name = null;
    
    public function __construct(Gateway $gateway, Factory $factory, $name)
    {
        $this->gateway = $gateway;
        $this->factory = $factory;
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function get($id)
    {
        $rawItem = $this->gateway->get($id);
        
        if(is_null($rawItem))
        {
            return null;
        }
        
        return $this->factory->make($rawItem);
    }
    
    public function add(Model $model)
    {
        $this->gateway->add($model->toArray());
    }
    
    public function update(Model $model)
    {
        $this->gateway->update($model->toArray());
    }
    
    public function remove($id)
    {
        $this->gateway->remove($id);
    }
    
    public function search(array $filter)
    {
        $this->gateway->search($filter);
    }
}