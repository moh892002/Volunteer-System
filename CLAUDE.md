# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Common Development Commands

### Docker Commands
- **Start application**: `docker-compose up --build`
- **Stop application**: `docker-compose down`
- **Run migrations**: `docker exec -it laravel_app php artisan migrate`
- **Seed database**: `docker exec -it laravel_app php artisan db:seed`
- **Access container shell**: `docker exec -it laravel_app bash`

### Local Development Commands (without Docker)
- **Install PHP dependencies**: `composer install`
- **Install Node dependencies**: `npm install`
- **Generate application key**: `php artisan key:generate`
- **Run migrations**: `php artisan migrate`
- **Seed database**: `php artisan db:seed`
- **Build frontend assets**: `npm run build`
- **Start development server**: `php artisan serve`
- **Run tests**: `php artisan test` or `vendor/bin/phpunit`
- **Run specific test**: `php artisan test --filter=TestName`

### Artisan Commands
- **List all routes**: `php artisan route:list`
- **Clear cache**: `php artisan cache:clear`
- **View environment config**: `php artisan config:cache`

## Code Architecture Overview

### MVC Structure
- **Models**: Located in `app/Models/` - Eloquent models representing database tables (Volunteer, Task, Workplace, Assignment, User)
- **Controllers**: Located in `app/Http/Controllers/` - Handle HTTP requests and return responses
- **Views**: Located in `resources/views/` - Blade templates for frontend rendering
- **Routes**: Located in `routes/` - Web routes definitions (web.php, volunteer.php, task.php, etc.)
- **Requests**: Located in `app/Http/Requests/` - Form request validation classes

### Key Features Structure
1. **Authentication**: Handled by `LoginController.php` with routes in `routes/web.php`
2. **Volunteer Management**: `app/Http/Controllers/VolunteersController.php` + `routes/volunteer.php`
3. **Task Management**: `app/Http/Controllers/TasksController.php` + `routes/task.php`
4. **Workplace Management**: `app/Http/Controllers/WorkplacesController.php` + `routes/workplace.php`
5. **Assignment System**: `app/Http/Controllers/AssignmentController.php` + `routes/assignment.php`
6. **Dashboard**: `app/Http/Controllers/DashboardController.php` + route in `routes/web.php`

### Policies & Authorization
- Located in `app/Policies/` - Laravel policies for authorization checks on models
- Each model has corresponding policy (VolunteerPolicy, TaskPolicy, etc.)

### Database
- Uses SQLite by default (`database/database.sqlite`)
- Migrations in `database/migrations/`
- Seeders in `database/seeders/`

### Frontend
- Built with Vite (`vite.config.js`)
- Bootstrap CSS framework
- Components in `resources/views/components/`
- Layouts in `resources/views/layouts/`
- Page-specific views in `resources/views/[module-name]/`

### Testing
- PHPUnit tests in `tests/` directory
- Unit tests in `tests/Unit/`
- Feature tests in `tests/Feature/`