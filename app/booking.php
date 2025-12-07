<?php
$page_title = 'Book Room - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_auth();

require_once '../includes/header.php';

$error = '';
$room_id = $_GET['room_id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ? AND is_available = 1");
$stmt->execute([$room_id]);
$room = $stmt->fetch();

if (!$room) {
    header('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $guests_adults = intval($_POST['guests_adults'] ?? 1);
    $guests_children = intval($_POST['guests_children'] ?? 0);
    $total_price = floatval($_POST['total_price'] ?? 0);

    if (empty($check_in) || empty($check_out)) {
        $error = 'Please select check-in and check-out dates.';
    } elseif (strtotime($check_in) < strtotime('today')) {
        $error = 'Check-in date cannot be in the past.';
    } elseif (strtotime($check_out) <= strtotime($check_in)) {
        $error = 'Check-out date must be after check-in date.';
    } elseif ($guests_adults < 1 || $guests_adults > 4) {
        $error = 'Number of adults must be between 1 and 4.';
    } elseif ($guests_children < 0 || $guests_children > 4) {
        $error = 'Number of children must be between 0 and 4.';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO bookings (user_id, room_id, check_in, check_out, total_price, guests_adults, guests_children, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
        ");

        if ($stmt->execute([get_user_id(), $room_id, $check_in, $check_out, $total_price, $guests_adults, $guests_children])) {
            $booking_id = $pdo->lastInsertId();
            header('Location: /app/payment.php?booking_id=' . $booking_id);
            exit();
        } else {
            $error = 'Booking failed. Please try again.';
        }
    }
}
?>

<div class="container">
    <div class="section">
        <h2 class="section-title">Book Your Room</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <div class="card">
                <img src="<?php echo htmlspecialchars($room['image_url']); ?>"
                    alt="<?php echo htmlspecialchars($room['type']); ?> Room"
                    style="width: 100%; height: 300px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1rem;">

                <h3 class="card-title"><?php echo htmlspecialchars($room['type']); ?> - Room <?php echo htmlspecialchars($room['room_number']); ?></h3>
                <p><strong>Floor:</strong> <?php echo htmlspecialchars($room['floor_number']); ?></p>
                <p><strong>Price per Night:</strong> ₹<?php echo number_format($room['price_per_night'], 2); ?></p>
                <p><?php echo htmlspecialchars($room['description']); ?></p>
            </div>

            <div class="card">
                <h3 class="card-title">Booking Details</h3>

                <form method="POST" action="">
                    <input type="hidden" id="price_per_night" value="<?php echo $room['price_per_night']; ?>">
                    <input type="hidden" id="total_price_hidden" name="total_price" value="0">

                    <div class="form-group">
                        <label for="check_in" class="form-label">Check-in Date</label>
                        <input type="date" id="check_in" name="check_in" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="check_out" class="form-label">Check-out Date</label>
                        <input type="date" id="check_out" name="check_out" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="guests_adults" class="form-label">Number of Adults</label>
                        <input type="number" id="guests_adults" name="guests_adults" class="form-input"
                            min="1" max="4" value="1" required>
                    </div>

                    <div class="form-group">
                        <label for="guests_children" class="form-label">Number of Children</label>
                        <input type="number" id="guests_children" name="guests_children" class="form-input"
                            min="0" max="4" value="0" required>
                    </div>

                    <div classs="form-group">
                        <label class="form-label">Total Price</label>
                        <div style="font-size: 2rem; font-weight: 700; color: var(--accent-blue);">
                            <span id="total_price">₹0.00</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary form-submit">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/public/js/booking.js?v=1.0.0"></script>

<?php require_once 'includes/footer.php'; ?>