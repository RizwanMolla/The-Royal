<?php
$page_title = 'Manage Bookings - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

require_once '../includes/header.php';

$stmt = $pdo->query("
    SELECT b.*, u.name as user_name, u.email as user_email, r.room_number, r.type
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN rooms r ON b.room_id = r.id
    ORDER BY b.created_at DESC
");
$bookings = $stmt->fetchAll();
?>

<div class="admin-dashboard">
    <div class="admin-hero">
        <div class="container">
            <div class="admin-hero-content">
                <h1 class="admin-title">Reservation Management</h1>
                <p class="admin-subtitle">View and manage all guest reservations</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section" style="padding-top: 2rem;">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    if ($_GET['success'] === 'approved') echo 'Cancellation approved successfully.';
                    elseif ($_GET['success'] === 'rejected') echo 'Cancellation rejected successfully.';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo 'An error occurred processing the cancellation.'; ?>
                </div>
            <?php endif; ?>

            <?php if (empty($bookings)): ?>
                <div class="card text-center">
                    <p>No bookings found.</p>
                </div>
            <?php else: ?>
                <div class="analytics-bookings-list">
                    <?php foreach ($bookings as $booking): ?>
                        <div class="analytics-booking-item">
                            <div class="analytics-booking-main">
                                <div class="analytics-booking-id">#<?php echo $booking['id']; ?></div>
                                <div class="analytics-booking-details">
                                    <span class="analytics-booking-guest"><?php echo htmlspecialchars($booking['user_name']); ?></span>
                                    <span class="analytics-booking-room"><?php echo htmlspecialchars($booking['type']); ?> - Room <?php echo $booking['room_number']; ?></span>
                                    <span class="analytics-booking-room" style="font-size: 0.85rem;"><?php echo htmlspecialchars($booking['user_email']); ?></span>
                                </div>
                            </div>
                            <div class="analytics-booking-meta">
                                <div style="display: flex; flex-direction: column; gap: 0.25rem; min-width: 120px;">
                                    <span class="analytics-booking-date">Check-in: <?php echo date('M j, Y', strtotime($booking['check_in'])); ?></span>
                                    <span class="analytics-booking-date">Check-out: <?php echo date('M j, Y', strtotime($booking['check_out'])); ?></span>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem; align-items: flex-end; min-width: 100px;">
                                    <span class="analytics-booking-price">₹<?php echo number_format($booking['total_price'], 0); ?></span>
                                    <span style="font-size: 0.85rem; color: var(--text-muted);"><?php echo $booking['guests_adults']; ?> Adults, <?php echo $booking['guests_children']; ?> Children</span>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                                    <span class="badge badge-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>

                                    <?php
                                    $cancellation_status = $booking['cancellation_status'] ?? 'none';
                                    if ($cancellation_status === 'requested'):
                                    ?>
                                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                                            <form method="POST" action="admin/handle-cancellation.php" style="display: inline;">
                                                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-sm" style="background-color: #10b981; color: white; border: none;">
                                                    Approve Cancel
                                                </button>
                                            </form>
                                            <form method="POST" action="admin/handle-cancellation.php" style="display: inline;">
                                                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    <?php elseif ($cancellation_status === 'approved'): ?>
                                        <span class="badge" style="background-color: rgba(107, 114, 128, 0.15); color: #6b7280;">Cancelled</span>
                                    <?php elseif ($cancellation_status === 'rejected'): ?>
                                        <span class="badge" style="background-color: rgba(239, 68, 68, 0.15); color: #ef4444;">Cancel Rejected</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>