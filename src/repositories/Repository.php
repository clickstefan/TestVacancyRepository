<?php 

namespace Endouble\TheVacancyRepositoryProblem\repositories;
use Endouble\TheVacancyRepositoryProblem\models\Vacancy;
use Endouble\TheVacancyRepositoryProblem\dataSources\DataSource;

interface Repository extends DataSource
{
    public function addDataSource(DataSource $dataSource);
    public function removeDataSource($dataSourceName);
}