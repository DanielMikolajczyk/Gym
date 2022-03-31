# Personal gym project

Simple cms web application for generating workouts to private clients.

### General info

This web application is a commercial project for speeding up the process of creating workouts, generating pdfs and managing the clients. 

### Technologies

* Php 8
* Symfony 5
* Symfony Cli
* Bootstrap 4

### Setup

To run this project, copy .env_example and set up local enviroments:
```
$ cd ../gym
$ cp .env_example .env
```

Then install dependencies locally using: 
```
$ composer install 
$ npm run dev -d
```

For setting up the database and populate it with example data:
```
$ docker-compose up -d 
$ symfony console doctrine:migrations:migrate
$ symfony console doctrine:fixtures:load
```

Finally, run it on local web server using:
```
$ symfony server:start -d
```





