<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

$room_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM bookings WHERE room_id = ?");
$stmt->execute([$room_id]);
$booking_count = $stmt->fetch()['count'];

if ($booking_count > 0) {
    header('Location: admin/rooms.php?error=' . urlencode('Cannot delete room with existing bookings.'));
    exit();
}

$stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
if ($stmt->execute([$room_id])) {
    header('Location: admin/rooms.php?success=deleted');
} else {
    header('Location: admin/rooms.php?error=' . urlencode('Failed to delete room.'));
}
exit();
