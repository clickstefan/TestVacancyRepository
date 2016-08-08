<?php

namespace Endouble\TheVacancyRepositoryProblem\gateways;

class InMemoryVacancyGateway implements Gateway
{
    private $data = [];
    
    public function get($id)
    {
        if( !is_numeric($id) )
        {
            throw new exceptions\GatewayInvalidArgumentException("Invalid id");
        }
        
        if(isset($this->data[$id]))
        {
            return $this->data[$id];
        }
        else
        {
            return null;
        }
    }
    
    public function add(array $data)
    {
        if( !isset($data['id']) || !is_numeric($data['id']) )
        {
            throw new exceptions\GatewayInvalidArgumentException("Invalid id");
        }
        
        if( isset($this->data[$data['id']]) )
        {
            throw new exceptions\GatewayDuplicateException("id allready in collection: ".$data['id']);
        }
        
        $this->data[$data['id']] = $data;
    }
    
    public function update(array $data)
    {
        if( !isset($data['id']) || !is_numeric($data['id']) )
        {
            throw new exceptions\GatewayInvalidArgumentException("Invalid id");
        }
        
        if( !isset($this->data[$data['id']]) )
        {
            throw new exceptions\GatewayMissingException("id missing from collection, can't update: ".$data['id']);
        }
        
        $this->data[$data['id']] = $data;
    }
    
    public function remove($id)
    {
        if( !is_numeric($id) )
        {
            throw new exceptions\GatewayInvalidArgumentException("Invalid id");
        }
        
        if( !isset($this->data[$id]) )
        {
            throw new exceptions\GatewayMissingException("id missing from collection, can't remove: ".$id);
        }
        
        unset($this->data[$id]);
    }
    
    public function search(array $filter)
    {
        // not implemented for memory
        return null;
    }
    
}