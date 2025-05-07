# 📦 Student Management API

**Tech Stack:** Laravel, Laravel Passport (OAuth2), MySQL

---

## 🔐 Main Features

- User authentication with Laravel Passport
- Full CRUD for students
- Protected API routes using `auth:api` middleware

---

## 📘 API Endpoints

### 🔐 Authentication
| Method | Endpoint           | Description       |
|--------|--------------------|-------------------|
| POST   | `/api/v1/login`    | Login             |
| POST   | `/api/v1/logout`   | Logout            |

### 👨‍🎓 Students
| Method | Endpoint                      | Description           |
|--------|-------------------------------|-----------------------|
| GET    | `/api/v1/students`            | List all students     |
| POST   | `/api/v1/students`            | Create new student    |
| PATCH  | `/api/v1/students/{id}`       | Partially update      |
| DELETE | `/api/v1/students/{id}`       | Delete student        |

---

## 🧪 Requirements

- PHP 8.x
- Composer
- MySQL running (via **XAMPP** or another tool)

---

## 🚀 Local Installation

> ⚠️ Make sure MySQL is running locally (e.g., with XAMPP) before starting.

1. Clone the repository  
2. Open your terminal in the project root  
3. Run the following commands:

```bash
composer install            # Install PHP dependencies
cp .env.example .env        # Create your .env file
php artisan passport:install  # Install Passport keys
php artisan serve           # Start local development server
