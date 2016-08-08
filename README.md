The Vacancy Repository problem
------------------------------

#Install:
* composer install

#Test:
* composer test

#Sample usage:
```
// create repository
$vacancyRepository = new VacancyRepository();

// add data sources
$dataSource1 = new InMemoryVacancyDataSource();
$vacancyRepository->addDataSource($dataSource1);
...
$vacancyRepository->addDataSource($dataSourceN);

// CRUD operations
$vacancyRepository->add($vacancy);
$vacancyRepository->update($vacancy);
$vacancyRepository->remove($id);
$vacancyRepository->read($id);
$vacancyRepository->search($filter);

```

#Simplified Class diagram:

![Simplified Class Diagram](http://yuml.me/diagram/scruffy/class/[<<Repository>>]<>-1..*->[<<DataSource>>], [<<DataSource>>]<-[<<Factory>>], [<<DataSource>>]<-[<<Gateway>>] "Simplified Class Diagram")
