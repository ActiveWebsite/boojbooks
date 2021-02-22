# Reading List App

Book - Reading List. Application made in Laravel - VUE

![Alt text](http://gerzahim.com/img/port_boojbooks.png "Book - Reading List")


## Live Demo
#### http://booj-books.site/
```sh
user:     admin@admin.com
password: password
```


## Project Files and Folder

Folder Structure:

```sh
Models          => app/Models/
Web Controllers => app/Http/Controllers/
Api Controllers => app/Http/Controllers/API/
Requests        => app/Http/Requests/
Services        => app/Http/Services/
Crud Views      => /resources/views/app
Vue Components  => /resources/js/app/
Tests           => app/tests/
Postman collection (root) BoojBooks.postman_collection.json    
```


## Installation

Clone the repo:

```sh
git clone https://github.com/gerzahim/appointments.git appointments
cd src/booj-books
```

Build Up Docker Container and Images:
```sh
# Install Docker Desktop App

# Locate the path of the docker-compose.yml File and Build the Docker Container
cd src/wf
docker-compose up -d --build

## Enter to book_app_container ##
docker exec -it book_app_container bash
```

Install PHP dependencies:
```sh
cd /var/www
composer install
```

Install NPM dependencies:

```sh
npm install && npm run dev
```

Build assets:

```sh
npm run dev
```

Setup Environment File configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```


To run the tests:
```
phpunit
```
