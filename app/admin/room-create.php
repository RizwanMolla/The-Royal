<?php
$page_title = 'Create Room - The Royal';
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

require_once '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = trim($_POST['room_number'] ?? '');
    $floor_number = intval($_POST['floor_number'] ?? 0);
    $price_per_night = floatval($_POST['price_per_night'] ?? 0);
    $type = $_POST['type'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    if (empty($room_number) || empty($type) || empty($description) || empty($image_url)) {
        $error = 'All fields are required.';
    } elseif ($floor_number < 1) {
        $error = 'Floor number must be at least 1.';
    } elseif ($price_per_night <= 0) {
        $error = 'Price must be greater than 0.';
    } elseif (!in_array($type, ['Standard', 'Deluxe', 'Suite'])) {
        $error = 'Invalid room type.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM rooms WHERE room_number = ?");
        $stmt->execute([$room_number]);

        if ($stmt->fetch()) {
            $error = 'Room number already exists.';
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO rooms (room_number, floor_number, price_per_night, type, description, image_url, is_available)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            if ($stmt->execute([$room_number, $floor_number, $price_per_night, $type, $description, $image_url, $is_available])) {
                header('Location: /app/admin/rooms.php?success=created');
                exit();
            } else {
                $error = 'Failed to create room. Please try again.';
            }
        }
    }
}
?>

<div class="container">
    <div class="section">
        <h2 class="section-title">Create New Room</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div style="max-width: 800px; margin: 0 auto;">
            <div class="card">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="room_number" class="form-label">Room Number</label>
                        <input type="text" id="room_number" name="room_number" class="form-input"
                            value="<?php echo htmlspecialchars($_POST['room_number'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="floor_number" class="form-label">Floor Number</label>
                        <input type="number" id="floor_number" name="floor_number" class="form-input"
                            min="1" value="<?php echo htmlspecialchars($_POST['floor_number'] ?? '1'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="type" class="form-label">Room Type</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="Standard" <?php echo ($_POST['type'] ?? '') === 'Standard' ? 'selected' : ''; ?>>Standard</option>
                            <option value="Deluxe" <?php echo ($_POST['type'] ?? '') === 'Deluxe' ? 'selected' : ''; ?>>Deluxe</option>
                            <option value="Suite" <?php echo ($_POST['type'] ?? '') === 'Suite' ? 'selected' : ''; ?>>Suite</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price_per_night" class="form-label">Price per Night (₹)</label>
                        <input type="number" id="price_per_night" name="price_per_night" class="form-input"
                            min="0" step="0.01" value="<?php echo htmlspecialchars($_POST['price_per_night'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-textarea" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="url" id="image_url" name="image_url" class="form-input"
                            value="<?php echo htmlspecialchars($_POST['image_url'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="is_available" class="form-checkbox"
                                <?php echo isset($_POST['is_available']) || !isset($_POST['room_number']) ? 'checked' : ''; ?>>
                            <span>Room is available for booking</span>
                        </label>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Create Room</button>
                        <a href="/app/admin/rooms.php" class="btn btn-tertiary" style="flex: 1; text-align: center;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>