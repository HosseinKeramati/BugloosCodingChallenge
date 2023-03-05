<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://bugloos.nl/wp-content/uploads/Bugloos-Logo.svg" width="400" alt="Bugloos Logo"></a></p>


# Bugloos Coding Challenge

This project implements a solution for retrieving microservices' logs with optional filter inputs.

#### Dependencies:

- PHP: v8.2
- Laravel: v10.2
- Composer: v2.5

-------

# Getting Started

### Step 1:
Clone the project in your local coputer:

```
git clone <repository-url>
```

### Step 2:
Copy `.env.example` to `.env` file and fill the `DB_DATABASE, DB_USERNAME, DB_PASSWORD` fields.

### Step 3:

Install dependencies using composer

```
composer install
```

### Step 4:

Migrate databse

```
php artisan migrate
```

### Step 5:

Seed microservice logs table using command below:

```
php artisan app:seed-db-from-log-file logs.txt
```
`logs.txt` should be available in the public folder. A sample log file is already exist in public folder.

### Step 6:

Serve project
```
php artisan serve
```
Now the project is live at (http://localhost:8000) and you can see [documentation](http://localhost:8000/api/documentation#/logs) for available end points.

-------