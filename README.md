# vacation_portal
## Overview
A vacation portal built using Object-Oriented PHP following the MVC architectural pattern. This project implements clean code principles without relying on frameworks.

## Technical Stack
- PHP 8.0 (OOP)
- Docker
- PHPUnit for testing
- MySQL
- Apache

## Architecture
- Model-View-Controller (MVC) pattern
- Data Access Objects (DAO)

## Key Features
- Containerized development environment
- Unit test coverage
- Database abstraction layer
- Clean code architecture
- Input validation
- Session management

## Setup
1. Clone repository
2. Run `docker-compose up`
3. Populate the database at `http://localhost:8080/public/DatabaseController/populateDatabase`
4. Access application at `http://localhost:8080/public/AuthController/login`

## Log in
1. Login credentials for the manager is username : admin and password : admin
2. Login credentials for a user is username : user and password : user

## Testing
Run tests using:
```bash
./vendor/bin/phpunit tests
```
