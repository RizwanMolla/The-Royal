<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'The Royal - Luxury Hotel'; ?></title>
    <link rel="stylesheet" href="/public/css/style.css?v=1.0.0">
</head>

<body class="<?php echo $body_class ?? ''; ?>">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/" class="logo">The Royal</a>

                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="nav-menu" id="navMenu">
                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?>
                            <a href="/app/admin/dashboard.php" class="nav-link">Dashboard</a>
                            <a href="/app/admin/rooms.php" class="nav-link">Rooms</a>
                            <a href="/app/admin/bookings.php" class="nav-link">Bookings</a>
                            <a href="/app/admin/analytics.php" class="nav-link">Analytics</a>
                        <?php else: ?>
                            <a href="/app/rooms.php" class="nav-link">Book Your Room</a>
                            <a href="/app/my-bookings.php" class="nav-link">My Bookings</a>
                        <?php endif; ?>

                        <div class="user-menu">
                            <button class="user-name-btn" id="userMenuBtn">
                                Hello, <?php echo htmlspecialchars(get_user_name()); ?> <span class="dropdown-icon">&#9662;</span>
                            </button>
                            <div class="dropdown-content" id="userDropdown">
                                <a href="/app/change-password.php">Change Password</a>
                                <a href="/app/logout.php">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/app/rooms.php" class="nav-link">Our Rooms</a>
                        <a href="/app/login.php" class="btn btn-secondary">Login</a>
                        <a href="/app/register.php" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <script src="/public/js/main.js" defer></script>
    <main>