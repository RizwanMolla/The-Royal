<?php
$page_title = 'Manage Rooms - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

require_once '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM rooms ORDER BY floor_number, room_number");
$rooms = $stmt->fetchAll();
?>

<div class="admin-dashboard">
    <div class="admin-hero">
        <div class="container">
            <div class="admin-hero-content">
                <div class="admin-hero-header">
                    <div>
                        <h1 class="admin-title">Room Management</h1>
                        <p class="admin-subtitle">Configure and manage all hotel rooms</p>
                    </div>
                    <a href="/the-royal/admin/room-create.php" class="btn btn-primary btn-large">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; margin-right: 0.5rem;">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Room
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section" style="padding-top: 2rem;">

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

            <div class="admin-rooms-grid">
                <?php foreach ($rooms as $room): ?>
                    <div class="admin-room-card">
                        <div class="admin-room-image">
                            <img src="<?php echo htmlspecialchars($room['image_url']); ?>"
                                alt="Room <?php echo htmlspecialchars($room['room_number']); ?>">
                            <span class="badge badge-<?php echo $room['is_available'] ? 'available' : 'unavailable'; ?> admin-room-badge">
                                <?php echo $room['is_available'] ? 'Available' : 'Unavailable'; ?>
                            </span>
                        </div>
                        <div class="admin-room-content">
                            <div class="admin-room-header">
                                <div>
                                    <h3 class="admin-room-number">Room <?php echo htmlspecialchars($room['room_number']); ?></h3>
                                    <p class="admin-room-type"><?php echo htmlspecialchars($room['type']); ?> • Floor <?php echo htmlspecialchars($room['floor_number']); ?></p>
                                </div>
                                <div class="admin-room-price">₹<?php echo number_format($room['price_per_night'], 2); ?></div>
                            </div>
                            <p class="admin-room-description"><?php echo htmlspecialchars(substr($room['description'], 0, 100)); ?>...</p>
                            <div class="admin-room-actions">
                                <a href="/the-royal/admin/room-edit.php?id=<?php echo $room['id']; ?>" class="btn btn-secondary btn-sm">
                                    Edit
                                </a>
                                <a href="/the-royal/admin/room-delete.php?id=<?php echo $room['id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this room?');">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>