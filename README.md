# Booj Reading List
*Beware of the person of one book. -- Thomas Aquinas*
## Task
Compose a site using the [Laravel](https://laravel.com/) framework that allows the user to create a list of books they would like to read. Users should be able to perform the following actions:
* Add or remove books from the list
* Change the order of the books in the list
* Sort the list of books by their author
* Display a book detail page with a minimum of author, publication date, and title

Please use the [ORM](https://laravel.com/docs/5.2/eloquent) rather than crafting queries by hand. 

##### Bonus points!

* Deploy it for real so we can play with it! (and then tell us about how you deployed it)
* Handle image uploading while adding books to the list
* Do something fancy like integrating an external API or handling user authentication

<hr />

## Deployment
* Ensure that the *storage* and *bootstrap/cache* directories are writable, e.g. using **chmod o+w -R _folder_** command.
* If using sqlite, be sure to create the sqlite database, e.g. using the command **touch database/database.sqlite**.
* Copy the *.env.example* file to *.env* and change the configuration variables to suit your system. In particular, *APP_KEY* must be set, e.g. using the command **php artisan key:generate**.
* Images are stored in *storage/public*. In order for this images to be displayable, a link to this folder to the public directory must be made. This can be done using the command ** php artisan storage:link **.
* Run the migrations and, optionally, the seeds to generate the database tables.

## Live Test
A live test can be found at (http://parasolarchives.com/site/booj/public). Note that because this website runs on a shared host that does not support symbolic links, image uploading has been disabled.
