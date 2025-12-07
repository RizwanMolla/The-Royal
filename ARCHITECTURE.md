# The Royal Hotel Booking Application - Architecture Overview

This document provides a detailed overview of the architecture, code workflow, and key components of "The Royal" hotel booking web application.

## Project Overview

"The Royal" is a comprehensive web-based hotel management and booking application that allows users to browse and book hotel rooms while providing administrators with tools to manage inventory, bookings, and analytics. It features a user-facing front-end for browsing rooms and making bookings, a secure admin panel for managing rooms, bookings, and viewing analytics, and a cancellation management system. The application is built using PHP with PDO for database abstraction, MySQL for data persistence, and a responsive CSS/JavaScript front-end.

## Directory Structure

The project is organized into the following directories:

-   `app/`: Contains all application logic and user-facing pages.
    -   `admin/`: Admin panel pages for managing rooms, bookings, analytics, and cancellations.
    -   Standard pages: `login.php`, `register.php`, `rooms.php`, `booking.php`, `payment.php`, `my-bookings.php`, `request-cancellation.php`, etc.
-   `config/`: Contains configuration files including database connection setup.
-   `includes/`: Contains reusable PHP components (authentication, header, footer, etc.).
-   `public/`: Contains publicly accessible assets (CSS, JavaScript, images).
-   `database/`: Contains SQL migration and setup scripts.
-   `docs/`: Contains documentation files including installation and migration guides.

## Core Files and Their Roles

-   **`index.php`**: The main landing page of the application. It displays the hotel's features, highlights, and provides navigation to other parts of the site.
-   **`config/database.php`**: Establishes the connection to the MySQL database using PDO (PHP Data Objects). It defines database credentials and creates a PDO object that is used throughout the application for all database operations.
-   **`includes/header.php`**: The common header component for all pages. It includes the navigation menu with the hotel logo, which dynamically changes based on the user's authentication status and role (unauthenticated user, registered user, or admin).
-   **`includes/footer.php`**: The common footer component for all pages, typically including closing HTML tags and links to JavaScript files for shared functionality.
-   **`includes/auth.php`**: Central to the application's security model. It handles user session management, authentication verification, role-based access control, and provides security functions for protecting admin-only content.
-   **`app/booking.php`**: Handles the complete booking process. It displays detailed room information, a booking form with date selection and guest count, and processes booking submissions.
-   **`app/payment.php`**: Manages the payment processing workflow after a booking is created.
-   **`app/my-bookings.php`**: Allows users to view their booking history and manage existing bookings.
-   **`app/request-cancellation.php`**: Enables users to request cancellation of their bookings.
-   **`app/admin/dashboard.php`**: The main admin panel page, providing an overview of key metrics and navigation to other admin functions.

## Execution Flow (Example: Booking a Room)

1.  **User Authentication**: The user must be logged in to book a room. The `booking.php` page calls the `check_auth()` function from `includes/auth.php` to ensure the user is authenticated. If not authenticated, they are redirected to `login.php`.
2.  **Room Selection**: The user selects a room from the `rooms.php` page and is redirected to `booking.php?room_id=<ID>`.
3.  **Displaying Room Details**: `booking.php` retrieves the selected room's details from the `rooms` table using the `room_id` parameter.
4.  **Form Submission**: The user fills out the booking form with required information:
    -   Check-in date
    -   Check-out date
    -   Number of guests
5.  **Data Validation**: Server-side validation in `booking.php` ensures:
    -   No empty fields
    -   Valid date ranges (check-out after check-in)
    -   Guest count is positive
    -   Room availability for selected dates
6.  **Database Insertion**: Upon successful validation, a new record is inserted into the `bookings` table with:
    -   User ID
    -   Room ID
    -   Check-in and check-out dates
    -   Initial status of 'pending'
7.  **Redirection to Payment**: The user is redirected to `payment.php` to complete the booking and process payment.

## Authentication

Authentication in The Royal is session-based and managed by security functions in `includes/auth.php`.

### Session Management
-   When a user logs in via `login.php`, their information is stored in the `$_SESSION` superglobal:
    -   `user_id`: Unique identifier for the user
    -   `user_name`: User's display name
    -   `role`: User's role ('user' for regular users, 'admin' for administrators)

### Authentication Functions
-   **`is_logged_in()`**: Returns true if a `user_id` exists in the current session, indicating an active user session.
-   **`is_admin()`**: Returns true if the logged-in user has the 'admin' role, indicating administrative privileges.
-   **`check_auth()`**: Enforces user authentication. Redirects unauthenticated users to the login page. Called at the start of user-protected pages.
-   **`check_admin()`**: Enforces admin-level authentication. Redirects non-admin users away from administrative pages. Called at the start of all admin pages.
-   **`get_user_id()`**: Safely retrieves the current user's ID from the session.
-   **`get_user_name()`**: Safely retrieves the current user's name from the session.

### Security Features
-   All sensitive pages verify authentication status before processing requests
-   Role-based access control prevents unauthorized access to admin functions
-   Sessions use PHP's built-in session handling with appropriate configuration

## Database Interaction

-   All database interactions are performed through the PDO (PHP Data Objects) object created in `config/database.php`.
-   The application uses **prepared statements** for all dynamic database queries to prevent SQL injection vulnerabilities.
-   Data is fetched from the database as **associative arrays** (`PDO::FETCH_ASSOC`), allowing easy access to column values by name.
-   Database operations include:
    -   User management (registration, login, profile updates)
    -   Room inventory management (CRUD operations)
    -   Booking operations (creation, updates, status changes)
    -   Cancellation request tracking

## User-Defined Functions

The application uses several utility functions for common operations, primarily centralized in `includes/auth.php` for authentication and security:

-   **`check_auth()`**: Enforces that a user is logged in; redirects to login page if not authenticated.
-   **`check_admin()`**: Enforces that a user has admin privileges; redirects if insufficient permissions.
-   **`is_logged_in()`**: Checks if a user is currently logged in without enforcing it.
-   **`is_admin()`**: Checks if the logged-in user is an admin without enforcing it.
-   **`get_user_id()`**: Safely retrieves the user's ID from the session with null-safe handling.
-   **`get_user_name()`**: Safely retrieves the user's name from the session with null-safe handling.

These functions follow the **DRY (Don't Repeat Yourself)** principle by centralizing security-related logic and eliminating code duplication across the application.

## Admin Section

The `app/admin/` directory contains a comprehensive administration panel with restricted access enforced by the `check_admin()` function. The admin panel provides:

-   **Room Management**: Create, edit, and delete hotel rooms with detailed information including pricing, availability status, descriptions, and images.
    -   `rooms.php`: Dashboard displaying all rooms with action buttons for edit/delete operations.
    -   `room-create.php`: Form for adding new rooms to the system.
    -   `room-edit.php`: Form for updating existing room details.
    -   `room-delete.php`: Handles room deletion with confirmation.

-   **Booking Management**: View and manage all user bookings across the system.
    -   `bookings.php`: Displays all bookings with status tracking and administrative actions.

-   **Cancellation Handling**: Process user booking cancellation requests.
    -   `handle-cancellation.php`: Manages approval/denial of cancellation requests from users.

-   **Analytics**: View comprehensive booking statistics and revenue reports.
    -   `analytics.php`: Displays key metrics including total bookings, revenue, occupancy rates, and trends.
