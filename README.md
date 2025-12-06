<h1 align="center">The Royal - Hotel Management System</h1>

<p align="center">
  A complete hotel management web application built with vanilla PHP, MySQL, and a custom CSS theme. This project showcases core backend and frontend development skills, including authentication, CRUD operations, and a responsive, modern user interface.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
</p>


---

## Key Features

#### 👤 Guest Features
- **User Authentication**: Secure registration and login system.
- **Room Browsing**: Browse available rooms with a premium, responsive UI.
- **Dynamic Booking**: Book rooms with date selection and dynamic price calculation.
- **Simulated Payment**: A complete, simulated payment processing flow.
- **Booking History**: View and manage personal booking history.
- **Responsive Design**: Fully functional on all devices, from mobile to desktop.

#### 👑 Admin Features
- **Admin Dashboard**: At-a-glance statistics for revenue, bookings, and room availability.
- **Room Management (CRUD)**: Full Create, Read, Update, and Delete functionality for hotel rooms.
- **Booking Management**: View all user bookings, statuses, and guest information.
- **Revenue Tracking**: Monitor total revenue from paid bookings.

## Installation & Setup

To get a local copy up and running, follow these steps.

### Prerequisites

- A local web server environment (e.g., [XAMPP](https://www.apachefriends.org/), WAMP, or MAMP).
- PHP 7.4 or higher.
- MySQL 5.7 or higher.

### Steps

1.  **Clone the Repository**
    ```sh
    git clone https://github.com/your-username/the-royal.git
    ```

2.  **Move to Server Directory**
    - Move the `the-royal` folder into your web server's root directory (e.g., `C:/xampp/htdocs/`).

3.  **Database Setup**
    - Open phpMyAdmin by visiting `http://localhost/phpmyadmin`.
    - Create a new database and name it `the_royal`.
    - Select the new database and navigate to the **Import** tab.
    - Click `Choose File`, select `setup.sql` from the project's root directory, and click `Go` to execute the script. This will create all necessary tables and seed them with default data.

4.  **Database Configuration**
    - The database connection is pre-configured for a default XAMPP setup in `config/database.php`. If your MySQL credentials differ, update them accordingly.
    ```php
    // config/database.php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root'); // Your DB username
    define('DB_PASS', '');     // Your DB password
    define('DB_NAME', 'the_royal');
    ```

5.  **Run the Application**
    - Open your web browser and navigate to `http://localhost`.

---

## Default Login Credentials

-   **Admin Account**
    -   **Email**: `admin@theroyal.com`
    -   **Password**: `password`
-   **Guest Account**
    -   **Email**: `guest@example.com`
    -   **Password**: `password`

---

<details>
<summary><h3>➤ Project Structure</h3></summary>

```
the-royal/
├── admin/                  # Admin panel pages
│   ├── dashboard.php       # Admin dashboard with statistics
│   ├── rooms.php           # Room management (CRUD)
│   ├── bookings.php        # View all bookings
│   └── ...
├── config/
│   └── database.php        # Database connection and configuration
├── includes/
│   ├── header.php          # Reusable header and navigation
│   ├── footer.php          # Reusable footer
│   └── auth.php            # Authentication and session management functions
├── public/
│   ├── css/style.css       # All custom CSS styles
│   └── js/                 # JavaScript files for interactivity
├── index.php               # Home page and room listings
├── login.php               # Login page
├── register.php            # Registration page
├── booking.php             # Room booking and price calculation page
├── my-bookings.php         # User's booking history
├── payment.php             # Payment summary and processing page
├── setup.sql               # Database schema and initial data
└── README.md
```
</details>

<details>
<summary><h3>➤ Security Measures</h3></summary>

-   **SQL Injection Prevention**: All database queries are performed using **Prepared Statements** with PDO, preventing malicious SQL injection.
-   **Cross-Site Scripting (XSS) Prevention**: All dynamic user-generated content is sanitized using `htmlspecialchars()` before being rendered in the browser.
-   **Secure Password Hashing**: User passwords are not stored in plaintext. They are securely hashed using the `password_hash()` and `password_verify()` functions (bcrypt algorithm).
-   **Session Protection**: `session_regenerate_id(true)` is used upon login to prevent session fixation attacks.

</details>

