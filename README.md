# WoodArt Interiors

A PHP/MySQL web application for managing a custom furniture business. The system allows customers to browse furniture and materials, submit orders, and track their progress, while managers and craftsmen have dedicated tools for managing production.

> **Project type:** School / educational web application  
> **Stack:** PHP, MySQL/MariaDB, HTML, CSS, JavaScript  
> **Recommended local environment:** XAMPP

## Features

### Customer
- Create an account and sign in.
- Browse the available furniture catalog.
- Search/filter furniture by name.
- Browse available materials.
- Submit furniture orders with a selected material and delivery address.
- View order history and current order status.
- View personal profile and log out.

### Manager
- Access a protected administration dashboard.
- Review customer order requests.
- Approve or reject requests.
- Edit order information.
- Delete orders.
- Add new furniture items.
- Add new materials.
- Register managers and craftsmen.
- View production/order information.

### Craftsman
- Access assigned orders.
- View customer, furniture, material, and order information.
- Update order deadlines.
- Update completion dates.
- Update production status.

### Additional
- Session-based authentication and role-based access control.
- Responsive interface based on the Landed HTML5 UP design.
- Font Awesome icons.
- Experimental face-recognition page using `p5.js` and `ml5.js`.

---

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP 8.2+ | Server-side application logic |
| MySQL / MariaDB | Database |
| HTML5 | Page structure |
| CSS3 / SCSS | Styling |
| JavaScript | Client-side interactions |
| jQuery | Front-end utilities |
| p5.js | Face-recognition experiment |
| ml5.js | Machine-learning functionality |
| XAMPP | Local Apache + MySQL environment |

The included database dump was created with **MariaDB 10.4.32** and **PHP 8.2.12**, so this combination is recommended for the closest match to the original development environment.

---

## Project Structure

```text
woodart_interiors/
│
├── index.php                  # Main landing page
├── login.php                  # Login page
├── registration.php           # Customer registration
├── registration_m.php         # Manager/craftsman registration
├── profile.php                # User profile
│
├── furniture.php              # Furniture catalog and search
├── material.php               # Materials catalog
├── orders.php                 # Customer's orders
│
├── admin.php                  # Manager dashboard
├── manager_requests.php       # Manager request approval
├── a_edit.php                 # Edit order
├── add_furniture.php          # Add furniture
├── add_material.php           # Add material
│
├── craftman_status.php        # Craftsman order management
├── contacts.php               # Contact page
├── face.html                  # Face-recognition experiment
│
├── assets/
│   ├── css/                   # CSS stylesheets
│   ├── js/                    # JavaScript files
│   ├── php/
│   │   ├── connection.php     # Database connection
│   │   ├── script.php         # Authentication/forms logic
│   │   └── logout.php         # Session logout
│   ├── sass/                  # SCSS source files
│   └── webfonts/              # Font Awesome fonts
│
├── images/                    # Website images
└── woodart_interiors.sql      # Database schema and sample data
```

---

## Database

The application uses a MySQL/MariaDB database named:

```text
woodart_interiors
```

The main tables are:

- `customers` — customer accounts
- `managers` — manager accounts
- `craftmen` — craftsman accounts
- `furnitures` — furniture catalog
- `materials` — available materials
- `requests` — customer order requests
- `orders` — approved/active orders
- `solvings` — order dates, deadlines, statuses, and completion dates

### Relationships

```text
customers ────────┐
                  │
furnitures ───────┼──> requests ───> orders ───> solvings
                  │                    │
materials ────────┘                    │
                                       │
craftmen ──────────────────────────────┘
```

The SQL dump already contains the table definitions, primary keys, foreign keys, auto-increment settings, and sample records.

---

## Installation

### 1. Install XAMPP

Install XAMPP with:

- Apache
- MySQL / MariaDB
- PHP

Start **Apache** and **MySQL** from the XAMPP Control Panel.

### 2. Copy the project

Place the project folder inside XAMPP's `htdocs` directory:

```text
C:\xampp\htdocs\woodart_interiors
```

On Windows, the application should then be accessible at:

```text
http://localhost/woodart_interiors/
```

### 3. Create the database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin/
```

Create a database called:

```text
woodart_interiors
```

Then import:

```text
woodart_interiors.sql
```

Alternatively, the SQL file can be imported directly from phpMyAdmin's **Import** tab.

### 4. Configure the database connection

Open:

```text
assets/php/connection.php
```

Configure the connection for your local MySQL/MariaDB installation:

```php
<?php

$hostname = "localhost";
$username = "YOUR_DATABASE_USERNAME";
$password = "YOUR_DATABASE_PASSWORD";
$db__name = "woodart_interiors";

$connect = mysqli_connect(
    $hostname,
    $username,
    $password,
    $db__name
);
```

Make sure the database name matches the database created in phpMyAdmin.

### 5. Open the application

Visit:

```text
http://localhost/woodart_interiors/
```

You can then register a customer account or sign in with an account already present in the imported database.

---

## User Roles

The application has three main roles.

### Customer

Customers can:

```text
Register
   ↓
Login
   ↓
Browse furniture/materials
   ↓
Create an order request
   ↓
Wait for manager approval
   ↓
Track order status
```

### Manager

Managers can:

```text
Login
   ↓
Admin Dashboard
   ├── Review requests
   ├── Approve/reject requests
   ├── Edit orders
   ├── Delete orders
   ├── Add furniture
   ├── Add materials
   └── Register staff
```

### Craftsman

Craftsmen can:

```text
Login
   ↓
View assigned orders
   ↓
Update deadline/status
   ↓
Set completion date
```

---

## Important Configuration Notes

### Database credentials

Do **not** commit real database passwords to a public Git repository.

The database connection should ideally be configured using environment variables or a local configuration file that is excluded from Git.

For example:

```text
.env
```

and add the file to `.gitignore`.

### Password hashing

The current project uses MD5 for password hashing. This is **not recommended for production applications**.

For a production version, replace MD5 with PHP's password hashing API:

```php
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
```

and authenticate with:

```php
password_verify($password, $passwordHash);
```

### SQL security

Some existing PHP pages build SQL queries directly from form/session values. Before deploying the application publicly, use prepared statements with `mysqli_prepare()` or PDO to protect against SQL injection.

---

## Main Pages

| Page | Description | Access |
|---|---|---|
| `index.php` | Home page | Public |
| `login.php` | Authentication | Public |
| `registration.php` | Customer registration | Public |
| `profile.php` | User profile | Authenticated |
| `furniture.php` | Furniture catalog | Authenticated |
| `material.php` | Material catalog | Authenticated |
| `orders.php` | Customer order history | Customer |
| `admin.php` | Order administration | Manager |
| `manager_requests.php` | Request management | Manager |
| `a_edit.php` | Edit an order | Manager |
| `add_furniture.php` | Add furniture | Manager |
| `add_material.php` | Add material | Manager |
| `registration_m.php` | Register staff | Manager |
| `craftman_status.php` | Update assigned orders | Craftsman |
| `contacts.php` | Contact information | Public |
| `face.html` | Face-recognition experiment | Public |

---

## Front-End

The project uses a responsive layout with:

- HTML5
- CSS3
- SCSS
- jQuery
- Font Awesome
- Responsive breakpoints
- Scroll and navigation effects

The main styles are located in:

```text
assets/css/
```

SCSS source files are located in:

```text
assets/sass/
```

JavaScript files are located in:

```text
assets/js/
```

---

## Face Recognition

`face.html` is a separate experimental feature that loads:

- `p5.js`
- `p5.dom`
- `p5.sound`
- `ml5.js`

The page uses:

```text
assets/js/script.js
```

for its client-side functionality.

This feature is experimental and is separate from the main furniture-order management workflow.

---

## Development

For local development:

1. Start Apache and MySQL in XAMPP.
2. Make changes to the PHP/HTML/CSS/JS files.
3. Refresh the browser.
4. Check PHP errors in the Apache/PHP logs if something fails.
5. Use phpMyAdmin to inspect or modify the database during development.

Recommended development environment:

```text
Windows
XAMPP
Apache
PHP 8.2+
MariaDB 10.4+
Chrome / Firefox / Edge
```

---

## Troubleshooting

### `localhost` does not open

Check that Apache is running in XAMPP.

Try:

```text
http://localhost/
```

### Database connection error

Check:

- MySQL/MariaDB is running.
- The database is named `woodart_interiors`.
- Username and password in `assets/php/connection.php` are correct.
- The MySQL server is using the expected port.

### `Table doesn't exist`

Import the provided:

```text
woodart_interiors.sql
```

into the `woodart_interiors` database.

### Login does not work

Check that:

- The account exists in one of `customers`, `managers`, or `craftmen`.
- The database was imported correctly.
- The database connection works.
- PHP sessions are enabled.

### Permission redirects

Several pages are protected by session-based role checks. For example, manager-only pages redirect users who do not have the `managers` role.

---

## Future Improvements

Potential improvements for a production-ready version:

- Replace MD5 with `password_hash()` / `password_verify()`.
- Use prepared SQL statements throughout the project.
- Move database credentials into environment variables.
- Add CSRF protection to forms.
- Add stronger server-side input validation.
- Add proper error handling for failed database queries.
- Add unique constraints for usernames/logins.
- Improve order status workflow and notifications.
- Add pagination for large furniture/order lists.
- Improve mobile responsiveness.
- Separate business logic from HTML using a clearer MVC-style structure.
- Add automated tests.
- Add an API for mobile applications or a Telegram bot.
- Deploy the application to a production PHP/MySQL hosting environment.

---

## License

This project was created as an educational web-development project.

If you plan to reuse the code commercially, review and replace any third-party assets according to their respective licenses.
