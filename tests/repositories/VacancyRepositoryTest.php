<?php

namespace Endouble\TheVacancyRepositoryProblem\tests\repositories;
use Endouble\TheVacancyRepositoryProblem;
use Endouble\TheVacancyRepositoryProblem\repositories\VacancyRepository;
use Endouble\TheVacancyRepositoryProblem\repositories\exceptions;
use Endouble\TheVacancyRepositoryProblem\models\Vacancy;
use Endouble\TheVacancyRepositoryProblem\factories\VacancyFactory;
use Endouble\TheVacancyRepositoryProblem\dataSources\InMemoryVacancyDataSource;
use Endouble\TheVacancyRepositoryProblem\dataSources\InMemoryVacancyDataSource2;

class VacancyRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $vacancyRepository;
    
    public function setUp()
    {
        $this->vacancyRepository = new VacancyRepository();
        
        $dataSource1 = new InMemoryVacancyDataSource();
        $this->vacancyRepository->addDataSource($dataSource1);
        
        $dataSource2 = new InMemoryVacancyDataSource2();
        $this->vacancyRepository->addDataSource($dataSource2);
        
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
        $this->vacancyRepository->add($vacancy);
        $inRepository = $this->vacancyRepository->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testGet(Vacancy $vacancy)
    {
        $this->setUpData();
        $inRepository = $this->vacancyRepository->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testUpdateNoChange(Vacancy $vacancy)
    {
        $this->setUpData();
        $this->vacancyRepository->update($vacancy);
        $inRepository = $this->vacancyRepository->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testUpdateWithChange(Vacancy $vacancy)
    {
        $this->setUpData();
        $vacancy->title.=' updated';
        $this->vacancyRepository->update($vacancy);
        $inRepository = $this->vacancyRepository->get($vacancy->id);
        $this->assertEquals($vacancy, $inRepository);
    }
    
    /**
    * @dataProvider vacancyProvider
    */
    public function testRemove(Vacancy $vacancy)
    {
        $this->setUpData();
        $this->vacancyRepository->remove($vacancy->id);
        $this->assertEquals(1, 1);
    }

    public function testSearch()
    {
        $this->setUpData();
        $searchResults = $this->vacancyRepository->search([]);
        $this->assertEquals(null, $searchResults);
    }

    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\repositories\exceptions\RepositoryDuplicateDataSourceException
     */
    public function testRepositoryDuplicateDataSourceException()
    {
        $dataSource1 = new InMemoryVacancyDataSource();
        $this->vacancyRepository->addDataSource($dataSource1);
    }

    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\repositories\exceptions\RepositoryException
     */
    public function testRepositoryException()
    {
        $dataSource1 = new InMemoryVacancyDataSource();
        $this->vacancyRepository->addDataSource($dataSource1);
    }

    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\repositories\exceptions\RepositoryMissingDataSourceException
     */
    public function testRepositoryMissingDataSourceException()
    {
        $this->vacancyRepository->removeDataSource("");
    }

    /**
     * @expectedException \Endouble\TheVacancyRepositoryProblem\repositories\exceptions\RepositoryUndefinedDataSourcesException
     */
    public function testRepositoryUndefinedDataSourcesException()
    {
        $this->vacancyRepository = new VacancyRepository();
        $this->vacancyRepository->get(1);
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
