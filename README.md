# Booj Reading List
*Beware of the person of one book. -- Thomas Aquinas*
## Task
Compose a site using the [Laravel](https://laravel.com/) or Vue framework that allows the user to create a list of books they would like to read. Users should be able to perform the following actions:
[x] Connect to a publically available API
[x] Create Postman collection and Vue app OR Laravel App 
[x] Add or remove items from the list
[x] Change the order of the items in the list
[x] Sort the list of items
[x] Display a detail page with at least 3 points of data to display
[x] Include unit tests
[x] Deploy it on the cloud - be prepared to describe your process on deployment

[Postman Collection](https://www.getpostman.com/collections/123b71dd0a50466c3c60)
To deploy:

Fresh install:
* `git clone`
* `composer install`
* `npm i`
* `php artisan key:generate`
* configure .env variables
* `php artisan migrate`
* `php artisan db:seed` (if applicable)
* `npm run prod`
* any further actions you wish to take such as `php artisan route:cache`, `php artisan config:cache`, and `php artisan view:cache` for performance increases on a production site

Website upgrade:
* `php artisan down`
* `git pull`
* `composer install`
* `npm i`
* `php artisan migrate`
* actions such as clearing the route, config, and/or view caches and then recaching them
* `npm run prod`
* `php artisan up`
