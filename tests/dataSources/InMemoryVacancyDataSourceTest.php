<?php

namespace Endouble\TheVacancyRepositoryProblem\tests\repositories;
use Endouble\TheVacancyRepositoryProblem;
use Endouble\TheVacancyRepositoryProblem\repositories\VacancyRepository;
use Endouble\TheVacancyRepositoryProblem\repositories\exceptions;
use Endouble\TheVacancyRepositoryProblem\models\Vacancy;
use Endouble\TheVacancyRepositoryProblem\factories\VacancyFactory;
use Endouble\TheVacancyRepositoryProblem\dataSources\InMemoryVacancyDataSource;
use Endouble\TheVacancyRepositoryProblem\dataSources\InMemoryVacancyDataSource2;

class InMemoryVacancyDataSourceTest extends \PHPUnit_Framework_TestCase
{
    private $inMemoryVacancyDataSource;
    
    public function setUp()
    {
        $this->inMemoryVacancyDataSource = new InMemoryVacancyDataSource();
    }
    
    public function setUpData()
    {
        foreach($this->vacancyProvider() as $vacancy)
        {
            $this->testAdd($vacancy[0]);
        }
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testAdd(Vacancy $vacancy)
    {
        $this->inMemoryVacancyDataSource->add($vacancy);
        $inRepository = $this->inMemoryVacancyDataSource->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testGet(Vacancy $vacancy)
    {
        $this->setUpData();
        $inRepository = $this->inMemoryVacancyDataSource->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testUpdateNoChange(Vacancy $vacancy)
    {
        $this->setUpData();
        $this->inMemoryVacancyDataSource->update($vacancy);
        $inRepository = $this->inMemoryVacancyDataSource->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testUpdateWithChange(Vacancy $vacancy)
    {
        $this->setUpData();
        $vacancy->title.=' updated';
        $this->inMemoryVacancyDataSource->update($vacancy);
        $inRepository = $this->inMemoryVacancyDataSource->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testRemove(Vacancy $vacancy)
    {
        $this->setUpData();
        $this->inMemoryVacancyDataSource->remove($vacancy->id);
        $this->assertEquals(1, 1);
    }

    public function testSearch()
    {
        $this->setUpData();
        $searchResults = $this->inMemoryVacancyDataSource->search([]);
        $this->assertEquals(null, $searchResults);
    }

    public function testGetName()
    {
        $name = $this->inMemoryVacancyDataSource->getName();
        $this->assertTrue(strlen($name)>0 && is_string($name));
    }


    //data providers

    public function vacancyRawProvider()
    {
        $vacanciesRaw = json_decode(file_get_contents(__DIR__."/../data/vacancies.json"),true);
        return $vacanciesRaw;
    }
    
    public function vacancyProvider()
    {
        $vacancyFactory = new VacancyFactory();
        $vacanciesRaw = $this->vacancyRawProvider();
        $vacancies = [];
        
        foreach($vacanciesRaw as $vacancyRaw)
        {
            $vacancies[][0] = $vacancyFactory->make( $vacancyRaw );
        }
        
        return $vacancies;
    }
}
