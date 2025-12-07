<?php
$page_title = 'Manage Rooms - The Royal';
require_once '../../config/database.php';
require_once '../../includes/auth.php';

check_admin();

require_once '../../includes/header.php';

$stmt = $pdo->query("SELECT * FROM rooms ORDER BY type, room_number");
$rooms = $stmt->fetchAll();
?>

<div class="admin-dashboard">
    <div class="admin-hero">
        <div class="container">
            <div class="admin-hero-content" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 class="admin-title">Room Management</h1>
                    <p class="admin-subtitle">Add, edit, and remove hotel rooms</p>
                </div>
                <a href="/app/admin/room-create.php" class="btn btn-primary btn-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 1.2rem; height: 1.2rem; margin-right: 0.5rem;">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add New Room
                </a>
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

            <?php if (empty($rooms)): ?>
                <div class="card text-center">
                    <p>No rooms found. Add a new room to get started.</p>
                </div>
            <?php else: ?>
                <div class="room-grid room-grid-admin">
                    <?php foreach ($rooms as $room): ?>
                        <div class="room-card fade-in">
                            <img src="<?php echo htmlspecialchars($room['image_url']); ?>"
                                alt="<?php echo htmlspecialchars($room['type']); ?> Room">
                            <div class="room-card-content">
                                <div class="room-type">
                                    <?php echo htmlspecialchars($room['type']); ?> - Room <?php echo htmlspecialchars($room['room_number']); ?>
                                </div>
                                <h3 style="font-size: 1.2rem;">₹<?php echo number_format($room['price_per_night'], 2); ?> / night</h3>
                                <p><?php echo htmlspecialchars(substr($room['description'], 0, 80)); ?>...</p>

                                <div class="room-actions">
                                    <span class="badge badge-<?php echo $room['is_available'] ? 'success' : 'danger'; ?>">
                                        <?php echo $room['is_available'] ? 'Available' : 'Unavailable'; ?>
                                    </span>
                                    <a href="/app/admin/room-edit.php?id=<?php echo $room['id']; ?>"
                                        class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="/app/admin/room-delete.php?id=<?php echo $room['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this room? This cannot be undone.');">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>