# vacation_portal

## Overview

A vacation portal built using Object-Oriented PHP following the MVC architectural pattern. This project implements clean code principles without relying on frameworks.
This is my first ever project in php.

## Technical Stack

- PHP 8.0 (OOP)
- Docker
- PHPUnit for testing
- MySQL
- Apache
- Composer for autoloading

## Architecture

- Model-View-Controller (MVC) pattern
- Data Access Objects (DAO)

## Key Features

- Containerized development environment
- Unit test coverage (focused on models)
- Database abstraction layer
- Clean code architecture
- Input validation
- Session management
- Comprehensive documentation through comments

## Setup

1. Clone the repository.
2. Run `docker-compose up --build` to build and start the containers.
3. Populate the database by navigating to `http://localhost:8080/public/DatabaseController/populateDatabase`.
4. Access the application at `http://localhost:8080/public/AuthController/login`.

## Log in

- Manager credentials: 
  - Username: `admin`
  - Password: `admin`
- User credentials: 
  - Username: `user`
  - Password: `user`

## Testing

The project includes a dedicated container for running tests. Due to constraints in installing dependencies within the container, the `vendor` directory is included in the repository to ensure proper mounting during testing.

To run the tests:

1. **Seed the Database**: Ensure the database is populated by accessing `http://localhost:8080/public/DatabaseController/populateDatabase`.
2. **Run Tests**: Just start the vacation_phpunit container

   Note: Tests are primarily designed for the models and will pass only on the first run after seeding the database.

3. **Reset Environment**: After running the tests, bring down the containers and remove volumes:
   ```bash
   docker-compose down -v
   ```
4. **Restart Application**: Start the application without running the tests:
   ```bash
   docker-compose up --build
   ```

By following these steps, you can ensure a clean environment for both testing and application usage. 

## Problems

- This project is vulnerable to sql injection
- It does not use a router
- Not all tests are not implemented
- Classes like Controller and DbhModel should be abstract
- Websockets could be used for automatically refreshing the page

