<?php
$page_title = 'Booking Successful - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_auth();

require_once '../includes/header.php';

$booking_id = $_GET['booking_id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT b.*, r.room_number, r.type
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    WHERE b.id = ? AND b.user_id = ?
");
$stmt->execute([$booking_id, get_user_id()]);
$booking = $stmt->fetch();
?>

<div class="container">
    <div class="section">
        <div style="max-width: 600px; margin: 0 auto; text-align: center;">
            <div class="card">
                <div style="font-size: 4rem; color: var(--success-color); margin-bottom: 1rem;">✓</div>
                <h2 class="card-title">Booking Confirmed!</h2>
                <p style="font-size: 1.125rem; color: var(--text-secondary); margin-bottom: 2rem;">
                    Your payment has been processed successfully.
                </p>

                <?php if ($booking): ?>
                    <div class="booking-details" style="text-align: left;">
                        <div class="detail-row">
                            <span class="detail-label">Booking ID:</span>
                            <span class="detail-value">#<?php echo $booking['id']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Room:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['type']); ?> - Room <?php echo htmlspecialchars($booking['room_number']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Check-in:</span>
                            <span class="detail-value"><?php echo date('F j, Y', strtotime($booking['check_in'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Check-out:</span>
                            <span class="detail-value"><?php echo date('F j, Y', strtotime($booking['check_out'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total Paid:</span>
                            <span class="detail-value" style="color: var(--accent-blue); font-weight: 700;">
                                $<?php echo number_format($booking['total_price'], 2); ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="/app/my-bookings.php" class="btn btn-primary" style="flex: 1;">
                        View My Bookings
                    </a>
                    <a href="/" class="btn btn-secondary" style="flex: 1;">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>