# Manajemen Persuratan HKI & Publikasi

![preview](/public/Video%20Project%2011.gif)

## About

**Manajemen Persuratan HKI & Publikasi** is a web-based application designed to manage Intellectual Property Rights (HKI) and publication submissions within the Informatics Study Program.

The application provides two main user roles:

* **Student** — The default role assigned when a new user registers. Students can submit HKI and publication applications and monitor the progress of their submissions.
* **Admin** — Has access to administrative features, including reviewing and approving student submissions, managing lecturers, managing announcements, and changing user roles to **Admin** or **Lecturer**.

## Features

* User login and registration
* Dashboard
* Announcement management
* Lecturer management (add, edit, and delete)
* User role management
* HKI and publication submission approval
* HKI submission
* Publication submission
* Submission progress tracking

## Tech Stack

* **Laravel** — Backend framework
* **PHP** — Programming language
* **Tailwind CSS** — Frontend styling framework
* **MySQL** — Database management system
* **JavaScript** — Client-side functionality
* **Vite** — Frontend asset bundling

# Installation Guide

The project can be installed without an existing database. Since the project already contains **Laravel migrations and seeders**, you only need to create an empty MySQL database. Laravel will automatically create the required tables and insert the initial data using the migration and seeder files.

## 1. Prerequisites

Install the following software before setting up the project:

* PHP **8.2 or later**
* Composer
* MySQL
* Node.js and npm
* Git (optional, if cloning the repository)

The project uses **Laravel 11.9+**, which requires PHP 8.2 or later.

If you are using XAMPP:

```text
Apache → Not required
MySQL  → Required
```

Apache is not required because Laravel can be run using the built-in development server with `php artisan serve`.

---

## 2. Clone or Copy the Project

If you are using Git:

```powershell
git clone https://github.com/wedawesnawa/manajemen-persuratan-hki.git
cd manajemen-persuratan-hki
```

Alternatively, extract the project ZIP file and open a terminal in the project directory.

Make sure the project contains files and directories such as:

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
composer.json
composer.lock
package.json
package-lock.json
.env.example
```

---

## 3. Install PHP Dependencies

Run:

```powershell
composer install
```

This installs the PHP dependencies specified in `composer.lock` and creates the `vendor/` directory.

It is recommended to use `composer install` rather than `composer update` when setting up an existing project because `composer update` may change the dependency versions.

---

## 4. Create the `.env` File

Create the environment configuration file from `.env.example`:

```powershell
copy .env.example .env
```

Then open:

```text
.env
```

---

## 5. Create an Empty MySQL Database

Make sure MySQL is running.

If you are using XAMPP:

```text
XAMPP → MySQL → Start
```

Create an empty database named:

```text
db_pkl
```

The database does **not** need to contain any tables.

The initial database structure should look like:

```text
MySQL
└── db_pkl
    └── empty
```

### Using phpMyAdmin

Open phpMyAdmin using the appropriate URL for your local environment.

Select **New → Create database** and create:

```text
db_pkl
```

---

## 6. Configure the Database

Open the `.env` file and configure the database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_pkl
DB_USERNAME=root
DB_PASSWORD=
```

Adjust the username, password, and port according to your MySQL configuration.

> `DB_PORT=3306` refers to the **MySQL port**, not the Apache port.

---

## 7. Generate the Application Key

Run:

```powershell
php artisan key:generate
```

If successful, Laravel will display:

```text
INFO  Application key set successfully.
```

---

## 8. Clear the Laravel Cache

Run:

```powershell
php artisan optimize:clear
```

This clears Laravel's cached configuration, routes, views, and other cached files.

---

## 9. Create the Database Tables and Insert Initial Data

Because the project does not require an existing database, Laravel can create the database structure using the migration files located in:

```text
database/migrations/
```

The simplest approach is:

```powershell
php artisan migrate --seed
```

This command performs two operations:

```text
Migration
    ↓
Create database tables
    ↓
Seeder
    ↓
Insert initial data
```

The project includes seeders such as:

```text
database/seeders/
├── DatabaseSeeder.php
├── DosenSeeder.php
└── UsersTableSeeder.php
```

Therefore, `php artisan migrate --seed` is recommended when installing the project from an empty database.

---

## 10. Install Frontend Dependencies

Run:

```powershell
npm install
```

This installs the JavaScript dependencies specified in `package.json` and creates:

```text
node_modules/
```

---

## 11. Build the Frontend Assets

Run:

```powershell
npm run build
```

After the build process is completed, Laravel should have:

```text
public/
└── build/
    ├── manifest.json
    └── assets/
```

This step is important because Laravel requires the Vite manifest when loading compiled frontend assets.

If `public/build/manifest.json` does not exist, Laravel may display an error such as:

```text
Illuminate\Foundation\ViteManifestNotFoundException
Vite manifest not found
```

---

## 12. Run the Application

Start the Laravel development server:

```powershell
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

Open the address in a web browser.

Since the frontend assets have already been compiled using:

```powershell
npm run build
```

you do not need to run `npm run dev` for this setup.

# Complete Installation Sequence

For a fresh installation, the following commands can be used in order:

```powershell
# 1. Enter the project directory
cd manajemen-persuratan-hki

# 2. Install PHP dependencies
composer install

# 3. Create the environment file
copy .env.example .env

# 4. Create an empty MySQL database named db_pkl
#    Then configure the DB_* values in .env

# 5. Generate the application key
php artisan key:generate

# 6. Clear Laravel cache
php artisan optimize:clear

# 7. Create database tables and insert initial data
php artisan migrate --seed

# 8. Install frontend dependencies
npm install

# 9. Build frontend assets
npm run build

# 10. Start the Laravel application
php artisan serve
```

Then open:

```text
http://127.0.0.1:8000
```

The application should now be ready to use.
