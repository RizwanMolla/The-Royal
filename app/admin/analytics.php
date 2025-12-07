<?php
$page_title = 'Analytics - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

require_once '../includes/header.php';

// Revenue Statistics
$stmt = $pdo->query("SELECT SUM(total_price) as total_revenue FROM bookings WHERE status = 'paid'");
$total_revenue = $stmt->fetch()['total_revenue'] ?? 0;

$stmt = $pdo->query("SELECT SUM(total_price) as pending_revenue FROM bookings WHERE status = 'pending'");
$pending_revenue = $stmt->fetch()['pending_revenue'] ?? 0;

// Booking Statistics
$stmt = $pdo->query("SELECT COUNT(*) as count FROM bookings");
$total_bookings = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'paid'");
$paid_bookings = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'");
$pending_bookings = $stmt->fetch()['count'];

// Room Type Performance
$stmt = $pdo->query("
    SELECT r.type, COUNT(b.id) as bookings, SUM(b.total_price) as revenue
    FROM rooms r
    LEFT JOIN bookings b ON r.id = b.room_id AND b.status = 'paid'
    GROUP BY r.type
    ORDER BY revenue DESC
");
$room_performance = $stmt->fetchAll();

// Recent Bookings
$stmt = $pdo->query("
    SELECT b.*, r.room_number, r.type, u.name as guest_name
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    JOIN users u ON b.user_id = u.id
    ORDER BY b.created_at DESC
    LIMIT 10
");
$recent_bookings = $stmt->fetchAll();

// Monthly Revenue (Last 6 months)
$stmt = $pdo->query("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        SUM(total_price) as revenue,
        COUNT(*) as bookings
    FROM bookings
    WHERE status = 'paid' AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month DESC
");
$monthly_stats = $stmt->fetchAll();
?>

<div class="admin-dashboard">
    <div class="admin-hero">
        <div class="container">
            <div class="admin-hero-content">
                <h1 class="admin-title">Analytics & Insights</h1>
                <p class="admin-subtitle">Performance metrics and revenue analysis</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Revenue Overview -->
        <div class="admin-stats-luxury">
            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Total Revenue</span>
                    <span class="luxury-stat-value">₹<?php echo number_format($total_revenue, 2); ?></span>
                    <span class="luxury-stat-meta">Paid bookings</span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>

            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Pending Revenue</span>
                    <span class="luxury-stat-value">₹<?php echo number_format($pending_revenue, 2); ?></span>
                    <span class="luxury-stat-meta">Awaiting payment</span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>

            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Total Bookings</span>
                    <span class="luxury-stat-value"><?php echo $total_bookings; ?></span>
                    <span class="luxury-stat-meta"><?php echo $paid_bookings; ?> paid, <?php echo $pending_bookings; ?> pending</span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>

            <div class="luxury-stat-item">
                <div class="luxury-stat-content">
                    <span class="luxury-stat-label">Payment Rate</span>
                    <span class="luxury-stat-value"><?php echo $total_bookings > 0 ? round(($paid_bookings / $total_bookings) * 100) : 0; ?>%</span>
                    <span class="luxury-stat-meta">Conversion rate</span>
                </div>
                <div class="luxury-stat-accent"></div>
            </div>
        </div>

        <!-- Monthly Performance -->
        <div class="analytics-section">
            <h3 class="analytics-section-title">Monthly Performance</h3>
            <p class="analytics-section-subtitle">Last 6 months revenue and booking trends</p>

            <div class="analytics-cards-grid">
                <?php foreach ($monthly_stats as $stat): ?>
                    <div class="analytics-month-card">
                        <div class="analytics-month-header">
                            <span class="analytics-month-name"><?php echo date('F', strtotime($stat['month'] . '-01')); ?></span>
                            <span class="analytics-month-year"><?php echo date('Y', strtotime($stat['month'] . '-01')); ?></span>
                        </div>
                        <div class="analytics-month-stats">
                            <div class="analytics-stat-item">
                                <span class="analytics-stat-value">₹<?php echo number_format($stat['revenue'], 0); ?></span>
                                <span class="analytics-stat-label">Revenue</span>
                            </div>
                            <div class="analytics-stat-divider"></div>
                            <div class="analytics-stat-item">
                                <span class="analytics-stat-value"><?php echo $stat['bookings']; ?></span>
                                <span class="analytics-stat-label">Bookings</span>
                            </div>
                        </div>
                        <div class="analytics-month-footer">
                            <span>Avg: ₹<?php echo number_format($stat['revenue'] / $stat['bookings'], 0); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Room Type Performance -->
        <div class="analytics-section">
            <h3 class="analytics-section-title">Room Type Performance</h3>
            <p class="analytics-section-subtitle">Revenue breakdown by room category</p>

            <div class="analytics-room-grid">
                <?php foreach ($room_performance as $perf): ?>
                    <div class="analytics-room-card">
                        <h4 class="analytics-room-type"><?php echo htmlspecialchars($perf['type']); ?></h4>
                        <div class="analytics-room-stats">
                            <div class="analytics-room-stat">
                                <span class="analytics-room-value">₹<?php echo number_format($perf['revenue'] ?? 0, 0); ?></span>
                                <span class="analytics-room-label">Total Revenue</span>
                            </div>
                            <div class="analytics-room-stat">
                                <span class="analytics-room-value"><?php echo $perf['bookings']; ?></span>
                                <span class="analytics-room-label">Bookings</span>
                            </div>
                            <div class="analytics-room-stat">
                                <span class="analytics-room-value">₹<?php echo $perf['bookings'] > 0 ? number_format($perf['revenue'] / $perf['bookings'], 0) : '0'; ?></span>
                                <span class="analytics-room-label">Avg. Value</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="analytics-section">
            <h3 class="analytics-section-title">Recent Activity</h3>
            <p class="analytics-section-subtitle">Latest 10 bookings</p>

            <div class="analytics-bookings-list">
                <?php foreach ($recent_bookings as $booking): ?>
                    <div class="analytics-booking-item">
                        <div class="analytics-booking-main">
                            <div class="analytics-booking-id">#<?php echo $booking['id']; ?></div>
                            <div class="analytics-booking-details">
                                <span class="analytics-booking-guest"><?php echo htmlspecialchars($booking['guest_name']); ?></span>
                                <span class="analytics-booking-room"><?php echo htmlspecialchars($booking['type']); ?> - Room <?php echo $booking['room_number']; ?></span>
                            </div>
                        </div>
                        <div class="analytics-booking-meta">
                            <span class="analytics-booking-date"><?php echo date('M j, Y', strtotime($booking['check_in'])); ?></span>
                            <span class="analytics-booking-price">₹<?php echo number_format($booking['total_price'], 0); ?></span>
                            <span class="badge badge-<?php echo $booking['status']; ?>">
                                <?php echo ucfirst($booking['status']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>