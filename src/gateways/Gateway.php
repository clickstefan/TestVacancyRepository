<?php

namespace Endouble\TheVacancyRepositoryProblem\gateways;
use Endouble\TheVacancyRepositoryProblem;

interface Gateway 
{
    public function get($id);
    public function add(array $data);
    public function update(array $data);
    public function remove($id);
}