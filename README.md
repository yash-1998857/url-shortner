# URL Shortener

A simple URL Shortener application built using Laravel 12 and MySQL and php version 8.3 and above.

## Setup

### 1. Clone the Project

Clone the GitHub repository:

```bash
git clone https://github.com/yash-1998857/url-shortner.git
cd url-shortner
```

### 2. Install Composer Dependencies

```bash
composer install
```

### 3. Create the Environment File

Copy `.env.example` to `.env`.

Windows:

```bash
copy .env.example .env
```
### 4. Configure MySQL Database

Create a MySQL database named:

```text
url_shortner
```

Open the `.env` file and update the database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortner
DB_USERNAME=root
DB_PASSWORD=
```

Make sure the MySQL server is running.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Migrations and Seed the Database

```bash
php artisan migrate --seed
```

This will create the required database tables and add the default SuperAdmin account.

Default SuperAdmin:

```text
Email: superadmin@example.com
Password: password
```

### 7. Start the Application

```bash
php artisan serve
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

## Login URLs

### User Login

```text
http://127.0.0.1:8000/login
```

### SuperAdmin Login

```text
http://127.0.0.1:8000/superadmin/login
```

## Main Features

### SuperAdmin

- Login and logout
- Create a new company
- Invite an Admin to a company
- View all companies
- View all generated short URLs
- View URL hit counts
- Cannot create short URLs

### Admin

- Login and logout
- Create short URLs
- View short URLs created within their company
- Invite another Admin
- Invite Members

### Member

- Login and logout
- Create short URLs
- View only their own short URLs

### Short URLs

- Generate short URLs from original URLs
- Public short URL access
- Redirect to the original URL
- Track URL hit count


## Application Flow

1. SuperAdmin logs in.
2. SuperAdmin creates a company and invites an Admin.
3. Admin registers and add password using the invitation link.
4. Admin logs in.
5. Admin can create short URLs.
6. Admin can invite another Admin or Member.
7. Invited users register and add password using the invitation link.
8. Members can create short URLs.
9. Short URLs can be opened publicly and redirect to the original URL.
