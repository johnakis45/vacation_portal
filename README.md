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
3. Execute database migrations
4. Access application at `http://localhost:8080/public/AuthController/login`

## Testing
Run tests using:
```bash
./vendor/bin/phpunit tests
```
