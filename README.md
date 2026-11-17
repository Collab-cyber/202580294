## PalaTrip

PalaTrip is a simple travel guide website that helps users discover popular tourist destinations and activities in Palawan.

## About the Website

The website focuses on different tourist destinations in Palawan.
Users can explore places, view destination information, and discover activities they can do during their trip.

PalaTrip also includes a login, registration, and profile page where users can view their basic information and keep their own travel history.

## Main Features

- Palawan tourist destinations
- Destination search and category filter
- Tourist activities
- Destination information
- Login page
- Registration page
- User profile
- Trip history (each user adds and sees only their own trips)

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP (sessions, form handling, PDO)
- MySQL / MariaDB (via XAMPP)

## Project Goal

The goal of PalaTrip is to provide a simple and user-friendly website for people who want to explore tourist destinations and activities in Palawan.

## Back-end (PHP + MySQL)

Login, registration, sessions and trip history are handled by PHP and saved in a MySQL database.

### Project structure

```
landing.php, index.php        Public pages (Explore / Home)
login.php, register.php       Login and registration forms (guests only)
profile.php                   My Profile + trip history + Add a Trip form (needs login)
auth/register.php             Validates the form, saves the user (hashed password)
auth/login.php                Checks email + password, starts the session
auth/logout.php               Ends the session (POST only)
trips/add.php                 Validates and saves a trip for the logged-in user
includes/init.php             Session start, database connection, helper functions
includes/header.php           Shared <head> + navigation bar (reads the PHP session)
includes/footer.php           Shared footer + script tags
config/database.php           PHP configuration (PDO connection to palatrip_db)
database/palatrip_db.sql      Database schema (users and trips tables)
css/style.css                 All styling (responsive)
js/destinations.js            List of Palawan destinations used by the search
js/script.js                  Mobile menu + destination search/filter
images/                       Photos of the 3 popular destinations
```

### Database tables

- **users**: `id`, `name`, `email` (unique), `password_hash`, `created_at`
- **trips**: `id`, `user_id` (foreign key to `users.id`), `destination`, `activity`, `trip_date`, `created_at`.
  Deleting a user also deletes their trips (`ON DELETE CASCADE`).

### How the login session works

- `session_start()` runs in `includes/init.php`, which every page includes.
- `auth/login.php` stores `$_SESSION['user_id']` after a correct password.
- `includes/header.php` checks that session on every page, so the navigation bar
  shows **My Profile / Logout** when logged in and **Login / Register** when not.
- `profile.php` calls `require_login()`; visitors who are not logged in are
  redirected to `login.php`, even if they type the URL directly.
- `profile.php` only loads trips where `user_id` matches the logged-in user.
- The user stays logged in until they click **Logout** (`auth/logout.php`).

### Security

- Passwords are stored with `password_hash()` and checked with `password_verify()`.
- All queries use PDO prepared statements (no SQL injection).
- All output is escaped with `htmlspecialchars()` (the `e()` helper).
- Every form has a CSRF token, checked by the handler before anything is saved.
- Logout only works through a POST form, not a plain link.
- The session ID is regenerated after login.
- Database errors are written to the PHP error log, never shown to visitors.
- Form values kept after an error are stored in the session, not in the URL.

### How to run (XAMPP)

1. Copy this folder to `C:\xampp\htdocs\202580294`.
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin` > **Import** > choose `database/palatrip_db.sql` > **Import**.
   The file is safe to import again; it keeps existing users.
4. Check `config/database.php` (default: host `localhost`, user `root`, empty password).
5. Open `http://localhost/202580294/landing.php`.

### Adding or changing destinations

Edit `js/destinations.js`. Each destination is one block. Put a photo in `images/`
and set `image: "images/your-photo.jpg"` to replace a "Photo coming soon" placeholder.

If you add a new destination, also add its name to `palawan_destinations()` in
`includes/init.php` so it appears in the **Add a Trip** dropdown.
