<?php
$page_title = 'Manage Rooms - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

require_once '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM rooms ORDER BY floor_number, room_number");
$rooms = $stmt->fetchAll();
?>

<div class="container">
    <div class="section">
        <div class="flex justify-between items-center mb-4">
            <h2 class="section-title" style="margin-bottom: 0;">Manage Rooms</h2>
            <a href="/the-royal/admin/room-create.php" class="btn btn-primary">Add New Room</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                if ($_GET['success'] === 'created') echo 'Room created successfully!';
                elseif ($_GET['success'] === 'updated') echo 'Room updated successfully!';
                elseif ($_GET['success'] === 'deleted') echo 'Room deleted successfully!';
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Floor</th>
                        <th>Type</th>
                        <th>Price/Night</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($room['room_number']); ?></strong></td>
                            <td><?php echo htmlspecialchars($room['floor_number']); ?></td>
                            <td><?php echo htmlspecialchars($room['type']); ?></td>
                            <td style="font-weight: 700; color: var(--accent-blue);">
                                $<?php echo number_format($room['price_per_night'], 2); ?>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $room['is_available'] ? 'available' : 'unavailable'; ?>">
                                    <?php echo $room['is_available'] ? 'Available' : 'Unavailable'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="/the-royal/admin/room-edit.php?id=<?php echo $room['id']; ?>"
                                        class="btn btn-secondary" style="padding: 0.5rem 1rem;">Edit</a>
                                    <a href="/the-royal/admin/room-delete.php?id=<?php echo $room['id']; ?>"
                                        class="btn btn-danger" style="padding: 0.5rem 1rem;"
                                        onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>