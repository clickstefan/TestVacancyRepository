<?php 

namespace Endouble\TheVacancyRepositoryProblem\repositories;
use Endouble\TheVacancyRepositoryProblem\dataSources\DataSource;
use Endouble\TheVacancyRepositoryProblem\models\Model;

abstract class AbstractRepository implements Repository
{
    private $dataSources = [];
    
    abstract public function getName();
    
    public function addDataSource(DataSource $dataSource)
    {
        if(isset($this->dataSources[$dataSource->getName()]))
        {
            throw new exceptions\RepositoryDuplicateDataSourceException("name allready in dataSources: ".$dataSource->getName());
        }
        $this->dataSources[$dataSource->getName()]=$dataSource;
    }
    
    public function removeDataSource($dataSourceName)
    {
        if(!is_string($dataSourceName))
        {
            throw new exceptions\RepositoryInvalidArgumentException("dataSourceName is not string");
        }
        
        if(!isset($this->dataSources[$dataSourceName]))
        {
            throw new exceptions\RepositoryMissingDataSourceException("name not in dataSources: ".$dataSourceName);
        }
        unset($this->dataSources[$dataSourceName]);
    }
    
    public function get($id)
    {
        if(!is_numeric($id))
        {
            throw new exceptions\RepositoryInvalidArgumentException("Id is not numeric");
        }
        
        if(empty($this->dataSources))
        {
            throw new exceptions\RepositoryUndefinedDataSourcesException("Data sources are not (yet) defined for repository");
        }
        
        foreach($this->dataSources as $dataSource)
        {
            $data = $dataSource->get($id);
            if(!is_null($data))
            {
                return $data;
            }
        }
        
        return null;
    }
    
    
    public function search(array $filter)
    {
        if(empty($this->dataSources))
        {
            throw new exceptions\RepositoryUndefinedDataSourcesException("Data sources are not (yet) defined for repository");
        }
        
        foreach($this->dataSources as $dataSource)
        {
            $data = $dataSource->search($filter);
            if(!is_null($data))
            {
                return $data;
            }
        }
        
        return null;
    }
    
    public function remove($id)
    {
        if(!is_numeric($id))
        {
            throw new exceptions\RepositoryInvalidArgumentException("Id is not numeric");
        }
        
        if(empty($this->dataSources))
        {
            throw new exceptions\RepositoryUndefinedDataSourcesException("Data sources are not (yet) defined for repository");
        }
        
        foreach($this->dataSources as $dataSource)
        {
            try
            {
                $dataSource->remove($id);
            }
            catch( GatewayMissingException $e )
            {
                // not found in current dataSource
            }
        }
        
        return null;
    }
    
    public function update(Model $domainObj)
    {
        if(empty($this->dataSources))
        {
            throw new exceptions\RepositoryUndefinedDataSourcesException("Data sources are not (yet) defined for repository");
        }
        
        foreach($this->dataSources as $dataSource)
        {
            try
            {
                $dataSource->update($domainObj);
            }
            catch( GatewayMissingException $e )
            {
                // not found in $dataSource
            }
        }
        
        return null;
    }
    
    public function add(Model $domainObj)
    {
        if(empty($this->dataSources))
        {
            throw new exceptions\RepositoryUndefinedDataSourcesException("Data sources are not (yet) defined for repository");
        }
        
        foreach($this->dataSources as $dataSource)
        {
            try
            {
                $dataSource->add($domainObj);
            }
            catch( GatewayDuplicateException $e )
            {
                // allready found in $dataSource
            }
        }
        
        return null;
    }
}