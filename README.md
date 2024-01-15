# Demo App

A demo application to illustrate how Admin works.

![Filament Demo](https://user-images.githubusercontent.com/21066418/180368112-cfccda8d-a442-43e3-8cf3-3ba04f42247d.png)

## Installation

Clone the repo locally:

```sh
git clone https://github.com/theloopcraft/demo.git
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Create a symlink to the storage:

```sh
php artisan storage:link
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit the url in your browser, and login with:

-   **Username:** admin@admin.com
-   **Password:** password
