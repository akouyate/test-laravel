# Laravel Task Management API

This project is a simple Task Management API built with Laravel. It allows users to create and retrieve tasks via RESTful endpoints. This guide will help you get started with setting up the project using Docker and running tests.

## Getting Started

### Prerequisites

Before you begin, make sure you have Docker installed on your system. If you don't have Docker, you can download and install it from [Docker's official website](https://www.docker.com/products/docker-desktop).

### Setting Up the Project

1. **Clone the Repository**

   First, clone the repository to your local machine:

   ```bash
   git clone [your-repo-url]
   cd [your-repo-name]
   ```

2. **Start Docker Containers**

   Run the following command to build and start the Docker containers:

   ```bash
   docker-compose up -d
   ```

   This will set up all the necessary services, such as the Laravel application server, database, etc.

3. **Install Dependencies**

   Next, install the PHP dependencies using Composer:

   ```bash
   docker-compose exec laravel.test composer install
   ```


4. **Run Migrations**

   To set up your database schema, run the migrations:

   ```bash
   docker-compose exec laravel.test php artisan migrate
   ```

### Running Tests

To run the test suite, use the following command:

```bash
docker-compose exec laravel.test ./vendor/bin/pest
```

This will execute all the tests written using Pest PHP testing framework.

## API Endpoints

The API currently supports the following endpoints:

- `POST /api/tasks`: Create a new task.
- `GET /api/tasks/:id`: Retrieve the details of a specific task by its unique identifier (ID). 

### POST /api/tasks

This endpoint creates a new task. You need to provide task details in the request body.

**Request Body Example:**

```json
{
  "text": "Sample Task",
  "tasks": ["call_reason", "call_actions"]
}
```

### GET /api/tasks/:id

This endpoint allows you to request detailed information about a single task, such as its description, status, and any other relevant data associated with it.

**Usage Example:**

To fetch details of a task with a specific ID, you would make a GET request to `/api/tasks/{task_id}`, where `{task_id}` is replaced with the actual ID of the task you want to retrieve.

**Response Example:**

The response will contain the detailed information of the specified task in JSON format.

```json
{
  "id": "uuid",
  "text": "Sample Task",
  "tasks": ["call_reason", "call_actions"]
}
```

