<?php

namespace Endouble\TheVacancyRepositoryProblem\factories;
use Endouble\TheVacancyRepositoryProblem\models\Vacancy;

class VacancyFactory implements Factory
{
    public function make(array $components)
    {
        return new Vacancy( $components['id'], $components['title'], $components['content'], $components['description'] );
    }
}