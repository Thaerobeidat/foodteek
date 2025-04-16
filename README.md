#  Laravel 11 Authentication API

This project is a backend RESTful API built using **Laravel 11**. It includes user authentication features such as:

- User registration
- User login/logout
- Password reset
- Profile update
- Token-based authentication with Laravel Sanctum
- Full feature testing for all endpoints

---

## 📂 Features

- 🛡️ Secure login and registration
- 🔄 Password reset with email and confirmation
- 🧾 Update user profile (name, email, date of birth, phone)
- ✅ Token authentication via Sanctum
- ✅ Clean API responses with meaningful messages
- 🧪 Feature tests included for all core functionalities

---

## 🛠️ Installation

### 1. Clone the repository
```bash
git clone https://github.com/your-username/laravel-auth-api.git
cd laravel-auth-api



2. Install dependencies
composer install
3. Configure environment file
cp .env.example .env
php artisan key:generate
4. Set up the database
Update .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodteek
DB_USERNAME=root
DB_PASSWORD=
Then run:
php artisan migrate
▶️ Running the App
php artisan serve
🔐 API Endpoints

Method | URI | Description | Auth Required
POST | /api/register | Register a new user | ❌
POST | /api/login | Login with email/password | ❌
POST | /api/reset-password | Reset password | ❌
POST | /api/logout | Logout current user | ✅
PUT | /api/user/profile | Update profile info | ✅
GET | /api/user | Get logged-in user info | ✅

✅ Included Feature Tests

🔐 Auth Tests
LoginTest

Validates email/password

Handles wrong credentials

Successful login with token

RegisterTest

Validates required fields

Valid email format & password confirmation

Stores user data correctly

ResetPasswordTest

Handles validation

Verifies user exists

Resets password successfully

LogoutTest

Logs out user and revokes token

Returns error if no token sent

👤 Profile Tests
UpdateProfileTest

Requires authentication

Validates profile fields

Successfully updates user info




📁 Project Structure
├── app/
│   └── Http/
│       └── Controllers/
│           └── UserController.php
├── routes/
│   └── api.php
├── tests/
│   └── Feature/
│       ├── Auth/
│       │   ├── LoginTest.php
│       │   ├── RegisterTest.php
│       │   ├── ResetPasswordTest.php
│       │   └── LogoutTest.php
│       └── User/
│           └── UpdateProfileTest.php
├── database/
│   └── factories/
│       └── UserFactory.php
└── .env
