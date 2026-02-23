# Food System – Browser setup

## 1. Open in browser (XAMPP)

- Start **Apache** and **MySQL** in the XAMPP Control Panel.
- In the browser go to: **http://localhost/foodsystem**
  - You will be redirected to **http://localhost/foodsystem/public** and the app should load.

If that doesn’t work, open directly: **http://localhost/foodsystem/public**

## 2. Create the database (first time only)

The app needs a MySQL database named `foodsystem`.

**Option A – phpMyAdmin**

1. Open **http://localhost/phpmyadmin**
2. Click **New** and create a database named **foodsystem** (collation: `utf8mb4_unicode_ci`).
3. Or open the **Import** tab, choose `database/create_database.sql` from this project, and run it.

**Option B – MySQL command line**

```bash
c:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS foodsystem;"
```

Then run migrations:

```bash
cd c:\xampp\htdocs\foodsystem
php artisan migrate
```

(Optional) To use database sessions again, in `.env` set:

```env
SESSION_DRIVER=database
```

and run `php artisan migrate` if you haven’t already (migrations create the `sessions` table).

## 3. Alternative: Laravel development server

You can also run the app with PHP’s built-in server (no Apache needed):

```bash
cd c:\xampp\htdocs\foodsystem
php artisan serve
```

Then open: **http://127.0.0.1:8000**

In `.env` set `APP_URL=http://127.0.0.1:8000` when using this method.
