# Laravel Task Management App

This is a Laravel-based task management application where users can create and manage tasks. The app allows users to create tasks, assign due dates, and track the status of tasks (Pending, Completed). This application includes functionality to assign tasks to users and supports database seeding for generating sample data.

## Requirements

Before you begin, ensure you have the following installed:

- Laravel Breeze , Tailwind CSS
- Composer
- MySQL 
- Laravel 11.x 

## Installation Steps

### 1. Clone the Repository

First, clone the repository to your local machine:

```bash
git clone https://github.com/Lakshanweerasingha/Junior_Developer_Test.git
cd Junior_Developer_Test
```

### 2. Install Dependencies

Install the required dependencies using Composer:

```bash
composer install
```

### 3. Set Up the Environment File

Copy the `.env.example` file to create your `.env` file:

```bash
cp .env.example .env
```

Then, open the `.env` file and update the following configuration for your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key

Generate the application key to secure user sessions and other encrypted data:

```bash
php artisan key:generate
```

### 5. Run Migrations

Run the migrations to set up the database schema:

```bash
php artisan migrate
```

This will create the necessary tables in the database, including the `users` and `tasks` tables.

### 6. Run Seeders

Run the seeders to populate the database with sample data:

```bash
php artisan db:seed
```

This will populate the `users` table and `tasks` table with sample data.

### 7. Run the Application

To start the development server:

```bash
php artisan serve
```

You can now access the application in your browser at `http://127.0.0.1:8000`.
