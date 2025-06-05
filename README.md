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

## 🧱 Project Structure

```
company-fast/
├── app/                 # Controllers, models, views
├── core/                # App, Controller, Database, Validator, etc.
├── public/              # Entry point (index.php)
├── views/               # Blade-style PHP templates
├── routes.php           # Centralized routing table
├── .env                 # Environment variables
├── docker-compose.yml   # Docker setup
├── downloads/           # .exe files to download
└── composer.json        # Composer autoloading & dependencies
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

---

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

- Add email verification
- Add audit logs for admin actions

---

## 🤝 License

MIT