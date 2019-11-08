# Checkpoint 2 | May the force be with you | PHP0919

## Description

This repository is the beginning of your new month challenge based on your favorite PHP MVC structure.

It still uses some cool vendors/libraries such as FastRouter (fast request php router), Twig and PHP_CodeSniffer.
For this one, we add our new friend : PHPUnit.

## Steps

1. Clone this repository from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```
4. Create a new database on your local server and import `checkpoint2.sql` in your SQL server,
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter, mean your localhost will target the `/public` folder.
6. Go to [http://localhost:8000](http://localhost:8000) with your favorite browser.
7. Follow instructions on the homepage available at `http://localhost:8000` to complete this new big quest !
8. Commit your changes on a branch named as CAMPUS_NOM_Prenom (i.e. NANTES_LEGUENEC_Erwan)


18/04/2019 @wildcodeschool.fr
