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

        <?php if (empty($bookings)): ?>
            <div class="card text-center">
                <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">You haven't made any bookings yet.</p>
                <a href="/the-royal/index.php" class="btn btn-primary">Browse Rooms</a>
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
                                    $<?php echo number_format($booking['total_price'], 2); ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($booking['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>