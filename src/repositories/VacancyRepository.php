<?php
namespace Endouble\TheVacancyRepositoryProblem\repositories;
use Endouble\TheVacancyRepositoryProblem\models\Vacancy;
use Endouble\TheVacancyRepositoryProblem\dataSources\DataSource;

class VacancyRepository extends AbstractRepository
{
    public function getName()
    {
        return 'VacancyRepository';
    }
}