<?php
$page_title = 'Payment - The Royal';
require_once 'config/database.php';
require_once 'includes/auth.php';

check_auth();

require_once 'includes/header.php';

$booking_id = $_GET['booking_id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT b.*, r.room_number, r.type, r.image_url, u.name as user_name
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    JOIN users u ON b.user_id = u.id
    WHERE b.id = ? AND b.user_id = ?
");
$stmt->execute([$booking_id, get_user_id()]);
$booking = $stmt->fetch();

if (!$booking) {
    header('Location: /the-royal/index.php');
    exit();
}

$check_in = new DateTime($booking['check_in']);
$check_out = new DateTime($booking['check_out']);
$nights = $check_in->diff($check_out)->days;
?>

<div class="container">
    <div class="section">
        <h2 class="section-title">Payment Summary</h2>

        <div style="max-width: 800px; margin: 0 auto;">
            <div class="booking-details">
                <h3 class="card-title">Booking Information</h3>

                <div class="detail-row">
                    <span class="detail-label">Guest Name:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($booking['user_name']); ?></span>
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
                    <span class="detail-label">Number of Nights:</span>
                    <span class="detail-value"><?php echo $nights; ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Guests:</span>
                    <span class="detail-value"><?php echo $booking['guests_adults']; ?> Adults, <?php echo $booking['guests_children']; ?> Children</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="badge badge-<?php echo $booking['status']; ?>">
                            <?php echo ucfirst($booking['status']); ?>
                        </span>
                    </span>
                </div>

                <div class="detail-row" style="font-size: 1.5rem; font-weight: 700;">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value" style="color: var(--accent-blue);">
                        $<?php echo number_format($booking['total_price'], 2); ?>
                    </span>
                </div>
            </div>

            <?php if ($booking['status'] === 'pending'): ?>
                <form method="POST" action="/the-royal/process-payment.php">
                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-large" style="width: 100%;">
                        Pay Now
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-success text-center">
                    Payment completed successfully!
                </div>
                <a href="/the-royal/my-bookings.php" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">
                    View My Bookings
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>