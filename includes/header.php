<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'The Royal - Luxury Hotel'; ?></title>
    <link rel="stylesheet" href="/the-royal/public/css/style.css">
</head>

<body class="<?php echo $body_class ?? ''; ?>">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/the-royal/index.php" class="logo">The Royal</a>

                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="nav-menu" id="navMenu">
                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?>
                            <a href="/the-royal/admin/dashboard.php" class="nav-link">Dashboard</a>
                            <a href="/the-royal/admin/rooms.php" class="nav-link">Rooms</a>
                            <a href="/the-royal/admin/bookings.php" class="nav-link">Bookings</a>
                            <a href="/the-royal/admin/analytics.php" class="nav-link">Analytics</a>
                        <?php else: ?>
                            <a href="/the-royal/rooms.php" class="nav-link">Book Your Room</a>
                            <a href="/the-royal/my-bookings.php" class="nav-link">My Bookings</a>
                        <?php endif; ?>

                        <span class="nav-link user-name">Hello, <?php echo htmlspecialchars(get_user_name()); ?></span>
                        <a href="/the-royal/logout.php" class="btn btn-secondary">Logout</a>
                    <?php else: ?>
                        <a href="/the-royal/rooms.php" class="nav-link">Our Rooms</a>
                        <a href="/the-royal/login.php" class="btn btn-secondary">Login</a>
                        <a href="/the-royal/register.php" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main>