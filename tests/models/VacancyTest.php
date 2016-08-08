<?php

namespace Endouble\TheVacancyRepositoryProblem\tests\models;
use Endouble\TheVacancyRepositoryProblem\models\Vacancy;

class VacancyTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider vacancyRawProvider
    */
    public function testToArray($components)
    {
        $vacancy = new Vacancy( $components['id'], $components['title'], $components['content'], $components['description'] );
        $vacancyArr = $vacancy->toArray();
        
        $this->assertEquals($components, $vacancyArr);
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
