## eduFlow

eduFlow is an educational platform built with Laravel, designed to connect students with learning opportunities and help teachers manage their courses.

The platform provides authentication, role-based access, course management, personalized course recommendations, and wishlist functionality.

# Features

# Authentication

- User registration and login
- Logout
- Password reset
- Authentication using JWT

# Teacher

- Create courses
- View owned courses
- Update courses
- Delete courses

# Student

- Browse recommended courses
- Update learning interests
- Add courses to a wishlist
- Remove courses from the wishlist

# Role-based access

Different permissions are provided depending on the user's role, such as Student or Teacher.

# Architecture

The project follows a layered backend structure:

Controllers
     ↓
 Services
     ↓
Repositories
     ↓
  Models
This structure helps separate responsibilities and keeps the application easier to maintain and extend.

# Technologies

- PHP
- Laravel
- Laravel API
- JWT Authentication
- REST API
- MySQL
- Composer
- PHPUnit

# Project Structure

app/
├── Http/
├── Models/
├── Repositories/
├── Services/
└── Providers/

database/
resources/
routes/
tests/
public/

# Installation

1. Clone the repository

git clone https://github.com/MOUAINE-FATIHA/eduFlow.git
cd eduFlow

2. Install PHP dependencies

composer install

3. Create the environment file

cp .env.example .env

4. Generate the application key

php artisan key:generate

5. Configure the database

Update the database configuration in your ".env" file.

6. Run migrations

php artisan migrate

7. Start the development server

php artisan serve

The application will then be available locally.

# Testing

The project includes a "tests" directory for automated testing.
Run the test suite with:

php artisan test

# Project Status

This project was developed as part of my learning journey in web development and backend architecture with Laravel.

---

Built with Laravel & PHP
