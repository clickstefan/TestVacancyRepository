<?php

namespace Endouble\TheVacancyRepositoryProblem\dataSources;
use Endouble\TheVacancyRepositoryProblem\gateways\InMemoryVacancyGateway;
use Endouble\TheVacancyRepositoryProblem\factories\VacancyFactory;

class InMemoryVacancyDataSource extends AbstractDataSource
{
    public function __construct()
    {
        parent::__construct(new InMemoryVacancyGateway(), new VacancyFactory(), 'InMemoryVacancy');
    }
}