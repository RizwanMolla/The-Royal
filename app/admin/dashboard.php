<?php
$page_title = 'Admin Dashboard - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

require_once '../includes/header.php';

$stmt = $pdo->query("SELECT SUM(total_price) as total_revenue FROM bookings WHERE status = 'paid'");
$total_revenue = $stmt->fetch()['total_revenue'] ?? 0;

$stmt = $pdo->query("SELECT COUNT(*) as count FROM bookings WHERE DATE(created_at) = CURDATE()");
$bookings_today = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM rooms");
$total_rooms = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM rooms WHERE is_available = 1");
$available_rooms = $stmt->fetch()['count'];
?>

<div class="admin-dashboard">
    <div class="admin-hero">
        <div class="container">
            <div class="admin-hero-content">
                <h1 class="admin-title">Management Console</h1>
                <p class="admin-subtitle">The Royal Hotel Operations</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Stats Overview with Luxury Design -->
        <div class="admin-stats-luxury">
            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Total Revenue</span>
                    <span class="luxury-stat-value">₹<?php echo number_format($total_revenue, 2); ?></span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>

            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Today's Bookings</span>
                    <span class="luxury-stat-value"><?php echo $bookings_today; ?></span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>

            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Total Rooms</span>
                    <span class="luxury-stat-value"><?php echo $total_rooms; ?></span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>

            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Available Now</span>
                    <span class="luxury-stat-value"><?php echo $available_rooms; ?></span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="admin-management-grid">
            <a href="/app/admin/rooms.php" class="management-section">
                <div class="management-header">
                    <h3>Room Management</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <p class="management-description">Configure rooms, pricing, and availability</p>
                <div class="management-footer">
                    <span class="management-count"><?php echo $total_rooms; ?> Rooms</span>
                </div>
            </a>

            <a href="/app/admin/bookings.php" class="management-section">
                <div class="management-header">
                    <h3>Reservations</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <p class="management-description">View and manage guest reservations</p>
                <div class="management-footer">
                    <span class="management-count"><?php echo $bookings_today; ?> Today</span>
                </div>
            </a>

            <a href="/app/admin/analytics.php" class="management-section">
                <div class="management-header">
                    <h3>Analytics</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <p class="management-description">Revenue reports and performance metrics</p>
                <div class="management-footer">
                    <span class="management-count">View Reports</span>
                </div>
            </a>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>