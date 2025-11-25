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

<div class="container">
    <div class="section">
        <h2 class="section-title">Manage Bookings</h2>

        <?php if (empty($bookings)): ?>
            <div class="card text-center">
                <p>No bookings found.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest</th>
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
                                <td><strong>#<?php echo $booking['id']; ?></strong></td>
                                <td>
                                    <?php echo htmlspecialchars($booking['user_name']); ?><br>
                                    <small style="color: var(--text-secondary);"><?php echo htmlspecialchars($booking['user_email']); ?></small>
                                </td>
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

<?php require_once '../includes/footer.php'; ?>