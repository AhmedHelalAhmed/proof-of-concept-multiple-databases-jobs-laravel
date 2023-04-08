# Here I want to proof we can run worker of laravel on multiple databases and hence we can have jobs table on each database separately

### If you have docker and docker compose installed

- ```cp .env.example .env```
- ``` docker-compose up ```
- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php composer install ``` to install dependencies

## Run commands against multiple databases

- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php  php artisan migrate --database=service1 ```
- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php  php artisan migrate --database=service2 ```
- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php  php artisan migrate --database=service2 ```

## Add jobs to multiple databases

- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan dispatch:job 1 ``` 
This will add job to service1 database
- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan dispatch:job 2 ``` 
This will add job to service2 database
- ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan dispatch:job 3 ``` 
This will add job to service3 database

## The goal

Run some jobs in multiple databases

## How to make worker run through different databases?

The idea to run queue:work with default connection set to different database

- when schedule run it run ```php artisan run:worker service1``` then ```php artisan run:worker service2```
  then ```php artisan run:worker service3```
- Each command will change the default connection of the database to custom connection service1 then service2 then
  service3
- Then run php artisan queue:work in this database

## Resources

[laravel Change Database connection run time](https://9to5answer.com/laravel-change-database-connection-run-time)

## Steps to test

- Create 3 databases: service1, service2 and service3
- ``` CREATE DATABASE service1;CREATE DATABASE service2;CREATE DATABASE service3; ```
- Migrate databases:
    - ```docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan migrate --database=service1```
    - ```docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan migrate --database=service2```
    - ```docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan migrate --database=service3```
- Create some jobs
    - ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan dispatch:job 1```
    - ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan dispatch:job 2```
    - ``` docker exec -it proof-of-concept-multiple-databases-jobs-laravel_php php artisan dispatch:job 3 ```
- Check posts table in each database after one minute
