## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication
TODO: pls summarize how to check "Authentication" bahavior

There is a button on the layout for login/register

You can register as a user or an article writer

going to /users will redirect you to login, 
but once logged in you can view /users

### Article Management

You can use Postman for Article Management

Retrieve All Articles **(GET)** /articles.json *all users*
Retrieve a Single Article **(GET)** /articles/{id}.json *all users*
Create an Article **(POST)** /articles.json *only logged in users*
Update an Article **(PUT)** /articles/{id}.json *only logged in article writer users*
Delete an Article **(DELETE)** /articles/{id}.json *only logged in article writer users*

You can also visit /articles for this

### Like Feature

You can visit /articles 

If not logged in: You can view the articles
If logged in as user: You can view and like the articles
If logged in as article writer: You can view, edit, delete and like the articles
