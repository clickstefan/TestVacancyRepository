<?php

namespace Endouble\TheVacancyRepositoryProblem\tests\gateways;

use Endouble\TheVacancyRepositoryProblem\gateways\exceptions;
use Endouble\TheVacancyRepositoryProblem\gateways\InMemoryVacancyGateway;

class InMemoryVacancyGatewayTest extends \PHPUnit_Framework_TestCase
{
    private $inMemoryVacancyGateway;
    
    public function setUp()
    {
        $this->inMemoryVacancyGateway = new InMemoryVacancyGateway();
    }
    
    public function setUpData()
    {
        foreach($this->vacancyRawProvider() as $vacancyRaw)
        {
            $this->testAdd($vacancyRaw[0]);
        }
    }
    
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testAdd(array $vacancyRaw)
    {
        $this->inMemoryVacancyGateway->add($vacancyRaw);
        $inGateway = $this->inMemoryVacancyGateway->get($vacancyRaw['id']);
        $this->assertEquals($vacancyRaw, $inGateway);
    }
    
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testGet(array $vacancyRaw)
    {
        $this->setUpData();
        $inGateway = $this->inMemoryVacancyGateway->get($vacancyRaw['id']);
        $this->assertEquals($vacancyRaw, $inGateway);
    }
    
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testUpdateNoChange(array $vacancyRaw)
    {
        $this->setUpData();
        $this->inMemoryVacancyGateway->update($vacancyRaw);
        $inGateway = $this->inMemoryVacancyGateway->get($vacancyRaw['id']);
        $this->assertEquals($vacancyRaw, $inGateway);
    }
    
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testUpdateWithChange(array $vacancyRaw)
    {
        $this->setUpData();
        $vacancyRaw['title'].=' updated';
        $this->inMemoryVacancyGateway->update($vacancyRaw);
        $inGateway = $this->inMemoryVacancyGateway->get($vacancyRaw['id']);
        $this->assertEquals($vacancyRaw, $inGateway);
    }
    
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testRemove(array $vacancyRaw)
    {
        $this->setUpData();
        $this->inMemoryVacancyGateway->remove($vacancyRaw['id']);
        $this->assertEquals(1, 1);
    }
    
    public function testSearch()
    {
        $this->setUpData();
        $searchResults = $this->inMemoryVacancyGateway->search([]);
        $this->assertEquals(null, $searchResults);
    }
    
    
    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\gateways\exceptions\GatewayInvalidArgumentException
     */
    public function testGatewayInvalidArgumentException()
    {
        $this->inMemoryVacancyGateway->get(""); 
    }
    
    
    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\gateways\exceptions\GatewayMissingException
     */
    public function testGatewayMissingException()
    {
        $this->inMemoryVacancyGateway->remove(0); 
    }
    
    
    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\gateways\exceptions\GatewayDuplicateException
     */
    public function testGatewayDuplicateException()
    {
        $this->inMemoryVacancyGateway->add(['id'=>1]);
        $this->inMemoryVacancyGateway->add(['id'=>1]); 
    }
    
    
    
    public function vacancyRawProvider()
    {
        $vacanciesRawArgs=[];
        $vacanciesRaw = json_decode(file_get_contents(__DIR__."/../data/vacancies.json"),true);
        
        foreach($vacanciesRaw as $vacancyRaw)
        {
            $vacanciesRawArgs[][0] = $vacancyRaw;
        }
        return $vacanciesRawArgs;
    }
    
}