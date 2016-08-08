<?php

namespace Endouble\TheVacancyRepositoryProblem\tests\factories;
use Endouble\TheVacancyRepositoryProblem\factories\VacancyFactory;

class VacancyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testMake(array $components)
    {
        $vacancyFactory = new VacancyFactory();
        $vacancy = $vacancyFactory->make($components);
        $this->assertEquals($components ,  $vacancy->toArray());
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