
# Innoqode Technical Assessment

  

Technical assessment

![Build Status](https://travis-ci.com/mthamayor/innoqode.svg?branch=main)

## Getting started

1. Documentation
2. Clone the repository
3. Building the project
4. Testing
5. Deployment

  

## Documentation  

This Documentation for this API can be found on [here](https://innoqodetechnicalassessment.docs.apiary.io/#)

## Clone the repository

Open the git bash terminal in your preferred directory and run
```
git clone https://github.com/mthamayor/innoqode.git
```  

## Building and running the project

- Create a `.env` file and copy the values of `.env.sample` to the created file.

- Using docker-compose, you can build the project with 
	```
	docker-compose build
	```
- Once the build is successful, run the command in the root folder from your terminal
	```
	sh scripts/start.sh
	``` 
	This is the equivalent of running 
	```
	docker-compose up -d && docker-compose exec php composer install && docker-compose run --rm artisan migrate
	``` 
This will
1. Start up the containers from the built images
2. Install dependencies
3. Migrate the database

The app will be exposed on `http://localhost:8080/api` for OSX

## Testing

You can run the test from the container with 
```
sh scripts/test.sh
```
or  
```
docker-compose up -d && docker-compose exec php composer install && docker-compose exec php composer run test
```
A coverage report will be generated in the `/coverage` folder.

You can stop the containers by running `sh scripts/stop.sh` or `docker-compose down`

## Deployment

A live version of the project is deployed on [heroku](https://innoqode.herokuapp.com/api)