<?php
$page_title = 'My Bookings - The Royal';
require_once 'config/database.php';
require_once 'includes/auth.php';

check_auth();

require_once 'includes/header.php';

$stmt = $pdo->prepare("
    SELECT b.*, r.room_number, r.type, r.image_url
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    WHERE b.user_id = ?
    ORDER BY b.created_at DESC
");
$stmt->execute([get_user_id()]);
$bookings = $stmt->fetchAll();
?>

<div class="container">
    <div class="section">
        <h2 class="section-title">My Bookings</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                if ($_GET['success'] === 'cancellation_requested') echo 'Cancellation request submitted successfully. Admin will review your request.';
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php
                if ($_GET['error'] === 'invalid') echo 'Invalid booking.';
                elseif ($_GET['error'] === 'already_requested') echo 'Cancellation already requested for this booking.';
                else echo 'An error occurred.';
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($bookings)): ?>
            <div class="card text-center">
                <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">You haven't made any bookings yet.</p>
                <a href="index.php" class="btn btn-primary">Browse Rooms</a>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Guests</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Booked On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>#<?php echo $booking['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($booking['type']); ?></strong><br>
                                    Room <?php echo htmlspecialchars($booking['room_number']); ?>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($booking['check_in'])); ?></td>
                                <td><?php echo date('M j, Y', strtotime($booking['check_out'])); ?></td>
                                <td>
                                    <?php echo $booking['guests_adults']; ?> Adults<br>
                                    <?php echo $booking['guests_children']; ?> Children
                                </td>
                                <td style="font-weight: 700; color: var(--accent-blue);">
                                    ₹<?php echo number_format($booking['total_price'], 2); ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($booking['created_at'])); ?></td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <?php if ($booking['status'] === 'pending'): ?>
                                            <a href="payment.php?booking_id=<?php echo $booking['id']; ?>"
                                                class="btn btn-primary btn-sm">
                                                Pay Now
                                            </a>
                                        <?php endif; ?>

                                        <?php
                                        $cancellation_status = $booking['cancellation_status'] ?? 'none';
                                        if ($cancellation_status === 'none'):
                                        ?>
                                            <form method="POST" action="request-cancellation.php" style="display: inline;">
                                                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to request cancellation?');">
                                                    Request Cancel
                                                </button>
                                            </form>
                                        <?php elseif ($cancellation_status === 'requested'): ?>
                                            <span class="badge badge-pending">Cancellation Pending</span>
                                        <?php elseif ($cancellation_status === 'approved'): ?>
                                            <span class="badge" style="background-color: rgba(107, 114, 128, 0.15); color: #6b7280;">Cancelled</span>
                                        <?php elseif ($cancellation_status === 'rejected'): ?>
                                            <span class="badge" style="background-color: rgba(239, 68, 68, 0.15); color: #ef4444;">Cancel Rejected</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>