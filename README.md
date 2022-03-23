# RENHEAD TASK

----------

## Getting started

### Installation

Please check the official laravel sail installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/9.x/sail#installation)

Clone the repository

    git clone https://github.com/NemanjaDjukic/renhead-task.git

Switch to the repo folder

    cd renhead-task

Copy the example env file and make the required configuration changes in the .env file or just change existing .env file

    cp .env.example .env

Install dependencies

    composer install

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder (**Set the database connection in .env before migrating**)

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

# Testing API

**If you are using postman, you can import collection from main folder of app - /Renhead.postman_collection.json**

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	 | **Value**            	 |
|----------	|------------------------|-----------------------|
| Yes      	| Accept     	     | application/json 	    |
| Yes      	| Content-Type 	         | application/json      |
| Optional 	| Authorization    	     | Bearer Token     	    |