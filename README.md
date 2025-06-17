# Registration & Tracking App

A modern MVC-style user activity tracking system built with PHP 8+, PDO, and Composer.  
Includes registration, login, role-based access, event logging, and graphical reports.

---

## 🚀 Features

- 🧭 Clean route handling via HTTP method + URI
- 👤 Login / Register / Logout with CSRF protection
- 🛡️ Role-based access (User/Admin)
- 📊 User activity tracking (page views, button clicks)
- 📈 Graphical reports + event filters
- 🐮 Page with "Buy a cow" button + EXE download
- 🐳 Docker support for local development

---

## ✅ Key Improvements

### ✅ PSR-4 Autoloading
- Autoloading is handled via `composer.json`.
- All classes follow PSR-4 namespace mapping:
  - `App\Core\` → `/Core`
  - `App\Controllers\` → `/Controllers`
  - `App\Controllers\Api\` → `/Controllers/Api`
  - `App\Services\` → `/Services`
  - `App\Models\` → `/Models`
  - `App\Middlewares\` → `/Middlewares`

### ✅ Dependency Injection (DI)
- Controllers receive services via constructor injection.
- Logic is moved out of controllers into Service classes.

### ✅ Removed loadModel()
- Dynamic model loading via `loadModel()` removed.
- Now all dependencies are explicitly declared via DI (resolved using `resolve()`).

### ✅ Separated Logic Layers
- Business logic (like logging, user handling) resides in dedicated services.
- Controllers handle request/response only.

### ✅ Better Exception Handling
- Centralized `handleException()` method used.
- Controllers no longer use `die()` or raw `echo`.

### ✅ CSRF Middleware
- CSRF token check is performed centrally.
- Token can be passed via header or hidden input.

### ✅ API/HTML Separation
- API endpoints are located in `App\Controllers\Api`.
- HTML-rendering controllers remain in `App\Controllers`.

## 📦 Composer Commands

```bash
composer install       # Install dependencies
composer dump-autoload # Rebuild autoloader
```

## 🗂 Folder Structure (PSR-4)
```
company-fast/
├── Core/
├── Controllers/
│   └── Api/
├── Models/
├── Services/
├── Middlewares/
├── views/
└── public/
```

---

## ⚙️ Requirements

- Docker + Docker Compose (or PHP 8.1+ with MySQL locally)
- Composer

---

## 🐳 Running with Docker

```bash
docker-compose up --build
```

App will be available at: [http://localhost:8083](http://localhost:8083)

---

## 🧪 Routes Overview

| Route         | Method | Description                          | Access  |
|---------------|--------|--------------------------------------|---------|
| `/register`   | GET    | Show registration form               | Public  |
| `/register`   | POST   | Handle registration                  | Public  |
| `/login`      | GET    | Show login form                      | Public  |
| `/login`      | POST   | Handle login                         | Public  |
| `/logout`     | GET    | Logout and destroy session           | User    |
| `/dashboard`  | GET    | Protected dashboard page             | User    |
| `/cow`        | GET    | Page with "Buy a cow" button         | User    |
| `/buy`        | POST   | Triggers buy action + logs it        | User    |
| `/download`   | GET    | Page with "Download" button          | User    |
| `/download`   | POST   | Downloads an .exe file               | User    |
| `/statistics` | GET    | Event log table + filters            | Admin   |
| `/reports`    | GET    | Graphs + table with daily activity   | Admin   |

## 📊 Statistics Page

- Filter logs by:
  - Date range
  - User (first name / last name / email)
  - Action type (`view_page`, `button_click`, etc.)
  - Page name (`pageA`, `login`, etc.)
  - Button name (`buy`, `download`)

---

## 📈 Reports Page

- Graph:
  - X axis — dates
  - Y axis — number of events per day
  - Events: `page view A`, `page view B`, `Buy a cow`, `Download`
- Table: daily summary of same events

---

## 🧼 Notes

- Passwords are hashed using `password_hash`
- CSRF tokens added to all POST forms
- Access control handled with `isAdmin()`
- All user actions are logged in `activity_logs`

---

## ✅ TODO
- Add audit logs for admin actions

---

## ✅ Routing Format

Route keys follow the format:
```
METHOD /path → controller@method
```

In `routes.php`, for example:
```php
'api/cow/buy.post' => [
    'controller' => 'Api/CowController',
    'method' => 'buy',
],
```


---

© 2025 Company Fast Project Refactor
