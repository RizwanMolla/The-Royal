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

<div class="container">
    <div class="section">
        <h2 class="section-title">Admin Dashboard</h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">$<?php echo number_format($total_revenue, 2); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?php echo $bookings_today; ?></div>
                <div class="stat-label">Bookings Today</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?php echo $total_rooms; ?></div>
                <div class="stat-label">Total Rooms</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?php echo $available_rooms; ?></div>
                <div class="stat-label">Available Rooms</div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="card">
                <h3 class="card-title">Room Management</h3>
                <p style="margin-bottom: 1.5rem;">Manage hotel rooms, add new rooms, edit or delete existing ones.</p>
                <a href="/the-royal/admin/rooms.php" class="btn btn-primary" style="width: 100%;">
                    Manage Rooms
                </a>
            </div>

            <div class="card">
                <h3 class="card-title">Booking Management</h3>
                <p style="margin-bottom: 1.5rem;">View all bookings, check payment status and guest information.</p>
                <a href="/the-royal/admin/bookings.php" class="btn btn-primary" style="width: 100%;">
                    View Bookings
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>