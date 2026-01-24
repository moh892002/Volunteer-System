# Volunteer Management System

A comprehensive Laravel-based volunteer management system for organizing volunteers, tasks, workplaces, and assignments.

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Vite, bootstrap CSS
- **Database:** SQLite (default, can be changed)
- **Containerization:** Docker, Docker Compose
- **Package Management:** Composer (PHP), NPM (Node.js)

## Features

- **User Authentication & Authorization**
    - Role-based access control (Admin & User roles)
    - Rate-limited login (5 attempts per minute)
    - Secure password hashing
    - Session management

- **Volunteer Management**
    - Create, read, update, and delete volunteers
    - Track volunteer skills and contact information
    - Search functionality
    - Soft deletes for data recovery

- **Task Management**
    - Manage various volunteer tasks
    - Detailed task descriptions
    - Search and filter capabilities
    - Soft deletes

- **Workplace Management**
    - Register and manage workplaces
    - Store location and contact details
    - Search functionality
    - Soft deletes

- **Assignment System**
    - Assign volunteers to tasks at specific workplaces
    - Track assignment status (Pending, Active, Completed)
    - Advanced filtering and search
    - Relationship tracking

- **Home Dashboard**
    - Public assignments overview table
    - Search assignments by volunteer, task, workplace, or status
    - Paginated results

## Installation

## Running with Docker

### Build and Start the Application

1. **Ensure Docker and Docker Compose are installed.**
2. **Build and run the container:**

    docker-compose up --build
    

    This will build the Docker image and start the Laravel application at [http://localhost:8000].

3. **(Optional) Run migrations and seeders inside the container:**

    Open a new terminal and run:

    docker exec -it laravel_app php artisan migrate --seed

### Stopping and Cleaning Up

- To stop the running container:

    docker-compose down
    

- To remove all stopped containers, networks, and dangling images (cleanup):

    docker system prune -f
    

### Requirements

- PHP >= 8.2
- Composer
- SQLite
- Node.js & NPM (for frontend assets)

### Setup Steps

1. **Clone the repository**

    git clone <https://github.com/moh892002/Volunteer-System>
    cd Volunteer-System

2. **Install PHP dependencies**

    composer install

3. **Install Node dependencies**

    npm install

4. **Environment setup**

    cp .env.example .env
    php artisan key:generate

5. **Database setup**

    # Create SQLite database

    touch database/database.sqlite

    # Run migrations

    php artisan migrate

    # Seed database with sample data (optional)

    php artisan db:seed

6. **Build frontend assets**

    npm run build

7. **Start the development server**

    php artisan serve

    Visit: http://127.0.0.1:8000

## Usage

### Default Credentials

you can login with:

**Admin Account:**

- Email: admin@example.com
- Password: password

### User Roles & Permissions

#### Admin Role

- Full access to all features
- Can create, edit, and delete all resources
- Can manage user accounts
- Can update assignment statuses

#### User Role

- Can view all resources
- Can create volunteers, tasks, workplaces, and assignments
- Can update tasks, workplaces, and assignments
- Cannot delete resources (admin only)
- Cannot edit volunteers (admin only)

### API Endpoints

#### Authentication

- `GET /` - Home page with assignments overview
- `GET /login` - Login page
- `POST /` - Process login
- `GET /register` - Registration page
- `POST /register` - Process registration
- `GET /logout` - Logout

#### Dashboard

- `GET /dashboard` - Main dashboard (authenticated users)

#### Volunteers

- `GET /volunteers` - List all volunteers
- `GET /volunteers/create` - Create volunteer form
- `POST /volunteers` - Store new volunteer
- `GET /volunteers/{id}/edit` - Edit volunteer form
- `PUT /volunteers/{id}` - Update volunteer
- `DELETE /volunteers/{id}` - Delete volunteer

#### Tasks

- `GET /tasks` - List all tasks
- `GET /tasks/create` - Create task form
- `POST /tasks` - Store new task
- `GET /tasks/{id}/edit` - Edit task form
- `PUT /tasks/{id}` - Update task
- `DELETE /tasks/{id}` - Delete task

#### Workplaces

- `GET /workplaces` - List all workplaces
- `GET /workplaces/create` - Create workplace form
- `POST /workplaces` - Store new workplace
- `GET /workplaces/{id}/edit` - Edit workplace form
- `PUT /workplaces/{id}` - Update workplace
- `DELETE /workplaces/{id}` - Delete workplace

#### Assignments

- `GET /assignments` - List all assignments
- `GET /assignments/create` - Create assignment form
- `POST /assignments` - Store new assignment
- `GET /assignments/{id}/edit` - Edit assignment form
- `PUT /assignments/{id}` - Update assignment
- `DELETE /assignments/{id}` - Delete assignment
- `PATCH /assignments/{id}/status` - Update assignment status
