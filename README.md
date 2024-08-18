# Laravel Library Management RESTful API

This Laravel application provides functionality for managing books and authors, including creating, retrieving, updating, and deleting records.

## Prerequisites

- Composer
- PHP >= 8.1
- MySQL

## Installation, Set Up, and Run Application

Follow these steps to set up the application:

1. **Clone the Repository**

   ```bash
   git clone https://github.com/aldiariq/library-mgmt.git
   cd library-mgmt

2. **Install Dependencies**

    ```bash
   composer install

3. **Set Up Environment File**

   Edit the .env file to configure your database and caching settings. For example:

    ```bash
   DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

4. **Generate Application Key**

   Generate a new application key for encryption:

    ```bash
   php artisan key:generate
   
5. **Run Migrations**

   Run the database migrations to create the necessary tables:

    ```bash
   php artisan migrate

6. **Seed the Database (Optional)**

   Seed the database with sample data:

    ```bash
   php artisan db:seed

7. **Run the Application**

   Start the Laravel development server:

    ```bash
   php artisan serve

## Unit Test

The following is a list of unit test endpoints:

### Authors Endpoint
- Create Author (POST /api/authors)
- Retrieve All Authors (GET /api/authors)
- Retrieve Author by ID (GET /api/authors/{id})
- Update Author (PUT /api/authors/{id})
- Delete Author (DELETE /api/authors/{id})

### Books Endpoint
- Create Book (POST /api/books)
- Retrieve All Books (GET /api/books)
- Retrieve Book by ID (GET /api/books/{id})
- Update Book (PUT /api/books/{id})
- Delete Book (DELETE /api/books/{id})
- Retrieve Books by Author (GET /api/authors/{id}/books)

Follow these steps to test the application:

1. **Run Unit and Feature Tests**

   ```bash
   php artisan test
