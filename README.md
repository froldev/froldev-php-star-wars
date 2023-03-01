# Star Wars | May the force be with you

![](https://github.com/froldev/php-star-wars/blob/master/presentation-starwars.png)

## Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;

## Installation

1. Clone the current repository.

```bash
$ git clone https://github.com/froldev/froldev-php-star-wars
```

2. Run composer.

```bash
$ composer install
```

3. Create _config/db.php_ from _config/db.php.dist_ file and add your DB parameters.

```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```

4. Import `starwars.sql` in your SQL server to create DataBase and import Data.

```bash
$ mysql -u root -p < starwars.sql
```

## Usage

1. Run the internal PHP webserver with `php -S localhost:8000 -t public/`.

2. Go to [http://localhost:8000](http://localhost:8000) with your favorite browser and see, add, update and remove your Star Wars.
