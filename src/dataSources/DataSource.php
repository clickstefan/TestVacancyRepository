<?php

namespace Endouble\TheVacancyRepositoryProblem\dataSources;
use Endouble\TheVacancyRepositoryProblem\models\Model;

interface DataSource
{
    public function getName();
    public function get($id);
    public function search(array $filter);
    public function add(Model $model);
    public function update(Model $model);
    public function remove($id);
}