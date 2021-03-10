Tutorial
=======================

[Run private queries with Laravel + GraphiQL](https://albertcito.com/blog/run-private-queries-with-laravel-graphiql/)


Base Admin
=======================

## Requitements
- PHP 7.4+
- postgres (PostgreSQL) 12.2

## To install:
- Clone this project
- Run `composer install` (Installs all the dependencies for your project)
- Create .env file `cp .env.example .env`  (remember update the database password and `DB_HOST=127.0.0.1`)
- Run `php artisan migrate` (Creates all of the database tables)

###  Add the base data and execute the tests ###
- Run `php artisan passport:install --force` (passport encryption keys)
- `composer dump-autoload`
- `php artisan db:seed` (Generates fake data in the database for testing purposes)
- `vendor/bin/phpunit` (to debug `--debug` and for Windows users use `vendor\bin\phpunit`)

### Reset the DB (Apply  it only in local)
- `php artisan migrate:fresh` to reinstall the db without data

###  To run it ###
- Run your project `php artisan serve` (Runs the server)
- Go to [http://127.0.0.1:8000/graphiql](http://127.0.0.1:8000/graphiql)

###  Run it before to send a PR ###
- `composer analyse`
- `composer fix-style` (to check `composer check-style`)
- `php artisan test`

###  To use the queries and mutations that request authentication:  ###

```
{
  login(
    email:"me@albertcito.com",
    password:"123456"
  ) {
    idUser
    accessToken
  }
}
```
- To acces to admin area you have to install [ModHeader](https://mod-header.appspot.com/) extension in your browser. And add a new header called `Authorization` with the value: `Bearer XXXXX` from access_token
- Now you can access the [admin area](http://127.0.0.1:8000/graphiql/admin)

###  Cofigure local emails Windows:  ###

- Downlad [Papercut](https://github.com/ChangemakerStudios/Papercut)
- Install the PaperCut application
- Default values are coming from file .env.example (copied on previos step)
