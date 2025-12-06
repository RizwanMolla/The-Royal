<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? 0;

    // Verify booking belongs to user
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->execute([$booking_id, get_user_id()]);
    $booking = $stmt->fetch();

    if (!$booking) {
        header('Location: my-bookings.php?error=invalid');
        exit();
    }

    // Check if already requested or approved
    if ($booking['cancellation_status'] !== 'none') {
        header('Location: my-bookings.php?error=already_requested');
        exit();
    }

    // Update cancellation status
    $stmt = $pdo->prepare("UPDATE bookings SET cancellation_status = 'requested' WHERE id = ?");
    $stmt->execute([$booking_id]);

    header('Location: my-bookings.php?success=cancellation_requested');
    exit();
}

header('Location: my-bookings.php');
exit();
