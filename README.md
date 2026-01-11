# Volunteer Management System

A comprehensive Laravel-based volunteer management system for organizing volunteers, tasks, workplaces, and assignments.

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

### Requirements

- PHP >= 8.2
- Composer
- SQLite (or MySQL/PostgreSQL)
- Node.js & NPM (for frontend assets)

### Setup Steps

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd Volunteer-System
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Database setup**

    ```bash
    # Create SQLite database
    touch database/database.sqlite

    # Run migrations
    php artisan migrate

    # Seed database with sample data (optional)
    php artisan db:seed
    ```

6. **Build frontend assets**

    ```bash
    npm run build
    ```

7. **Start the development server**

    ```bash
    php artisan serve
    ```

    Visit: http://127.0.0.1:8000

## Usage

### Default Credentials

After seeding the database, you can login with:

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

### Key Features Explained

#### Authorization Policies

The system uses Laravel policies for fine-grained authorization:

- `VolunteerPolicy` - Controls volunteer access
- `TaskPolicy` - Controls task access
- `WorkplacePolicy` - Controls workplace access
- `AssignmentPolicy` - Controls assignment access

#### Soft Deletes

All main models use soft deletes, allowing:

- Data recovery if accidentally deleted
- Maintaining referential integrity
- Audit trail of deleted records

#### Form Request Validation

Dedicated request classes ensure data integrity:

- `VolunteerRequest` - Validates volunteer data
- `TaskRequest` - Validates task data
- `WorkplaceRequest` - Validates workplace data
- `AssignmentRequest` - Validates assignment data

#### Rate Limiting

Login attempts are rate-limited to prevent brute force attacks:

- Maximum 5 attempts per minute per IP
- Automatic lockout with countdown
- Cleared on successful login

### Development

#### Running Tests

```bash
php artisan test
```

#### Code Style

```bash
./vendor/bin/pint
```

#### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Security Features

1. **CSRF Protection** - All forms include CSRF tokens
2. **Password Hashing** - Bcrypt hashing for passwords
3. **Rate Limiting** - Login attempt throttling
4. **SQL Injection Prevention** - Eloquent ORM with parameter binding
5. **XSS Protection** - Blade template escaping
6. **Authorization** - Policy-based access control
7. **Session Security** - Secure session management

## Recent Updates

### Version 1.1.0

- **Registration Fixes**: Enhanced user registration with improved validation, logging, and error handling for better reliability and debugging
- **Home View Table Addition**: Added a public home page displaying assignments in a responsive table format with volunteer avatars and status badges
- **Route Changes**: Updated routing structure with dedicated home route (`/`) for public assignments overview, separate from authenticated dashboard
- **Search Functionality**: Implemented search feature on home page allowing users to filter assignments by volunteer name, task name, workplace name, or status

### Version 1.0.0 (Initial Release)

- User authentication and authorization
- Volunteer management
- Task management
- Workplace management
- Assignment system with status tracking
- Search and filter functionality
- Soft deletes
- Rate limiting
- Comprehensive validation
- Database seeders

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, please open an issue in the repository or contact the development team.
