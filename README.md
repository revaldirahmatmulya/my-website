# Personal Portfolio & Project Showcase

A modern, minimalist, and elegant personal portfolio website built with **Laravel 11** and **Tailwind CSS**.

---

## ✨ Features

- **Dark Elegance Aesthetic**: Sleek midnight slate theme (`#080c14`), ambient subtle glows, glassmorphic cards, and clean typography powered by **Plus Jakarta Sans**.
- **Full-Screen Hero Section**: Full viewport height (`min-h-screen`) introduction with vertical centering and smooth scroll-down animation.
- **Projects Showcase**: Interactive cards displaying project descriptions, tech stack pills, and live demo / source code links.
- **Instant Client-Side Search**: Filter projects in real-time by title or technology tags without page reloads.
- **Direct Contact & Social Links**: Quick email actions with **1-Click Copy Email** (with instant feedback) and direct links to GitHub & LinkedIn.
- **Full Project CRUD (Admin Panel)**: Secure backend management to create, view, update, and delete projects.
- **Zero-Config Profile**: Easily customize name, role, bio, and social links via `.env`.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11, PHP 8.4
- **Database**: SQLite
- **Frontend / Styling**: Tailwind CSS v4, Blade Templates, Vite
- **Testing**: PHPUnit Feature & Unit Tests

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+ (PHP 8.4 recommended)
- Composer 2.x
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**:
   ```bash
   git clone https://github.com/revaldirahmatmulya/my-website.git
   cd my-website
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install frontend dependencies & compile assets**:
   ```bash
   npm install
   npm run build
   ```

4. **Environment setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run database migrations and seed default projects**:
   ```bash
   php artisan migrate --seed
   ```

6. **Start local server**:
   ```bash
   php artisan serve
   ```
   Visit **`http://127.0.0.1:8000`** in your browser.

---

## 🔑 Admin Management

- **Login URL**: `http://127.0.0.1:8000/login`
- **Default Email**: `admin@example.com`
- **Default Password**: `password`

---

## 🧪 Running Tests

Run the full PHPUnit test suite:
```bash
php artisan test --compact
```
