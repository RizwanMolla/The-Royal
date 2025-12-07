<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

check_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? 0;
    $action = $_POST['action'] ?? '';

    if (!in_array($action, ['approve', 'reject'])) {
        header('Location: /app/admin/bookings.php?error=invalid_action');
        exit();
    }

    $status = $action === 'approve' ? 'approved' : 'rejected';

    // Update cancellation status
    $stmt = $pdo->prepare("UPDATE bookings SET cancellation_status = ? WHERE id = ?");
    $stmt->execute([$status, $booking_id]);

    // If approved, also update booking status to cancelled and make room available
    if ($action === 'approve') {
        $stmt = $pdo->prepare("
            UPDATE rooms r
            INNER JOIN bookings b ON r.id = b.room_id
            SET r.is_available = 1
            WHERE b.id = ?
        ");
        $stmt->execute([$booking_id]);
    }

    header('Location: /app/admin/bookings.php?success=' . $action . 'd');
    exit();
}

header('Location: /app/admin/bookings.php');
exit();
