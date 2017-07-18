# Neo Web Service

## Requirements

* PHP
* MySQL

## Installation

* Clone project

```bash
git clone git@github.com:Markard/neo_web_service.git
```

* Install related packages via composer:
 
```bash
composer install
```

* Migrate database:

```bash
php bin/console doctrine:migrations:migrate
```

## Synchronize with NASA API

By default the following command sync data for 3 days from now. But you can specify start date as argument.
The max range in one query is 7 days. Format: Y-m-d.

```bash
php bin/console neo:synchronize
```

## Start server

```bash
php bin/console server:run
```

## Endpoints

* http://127.0.0.1:8000/ - landing
* http://127.0.0.1:8000/neo/hazardous - returns all potentially hazardous neo's
* http://127.0.0.1:8000/neo/fastest?hazardous=(true|false) - returns the fastest neo
* http://127.0.0.1:8000/neo/best-year?hazardous=(true|false) - returns a year with most asteroids
* http://127.0.0.1:8000/neo/best-month?hazardous=(true|false) - returns a month with most asteroids (not a month in a year)
