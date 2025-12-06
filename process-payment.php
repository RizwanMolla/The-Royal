<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? 0;

    $stmt = $pdo->prepare("SELECT id FROM bookings WHERE id = ? AND user_id = ? AND status = 'pending'");
    $stmt->execute([$booking_id, get_user_id()]);

    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'paid' WHERE id = ?");
        $stmt->execute([$booking_id]);

        header('Location: success.php?booking_id=' . $booking_id);
        exit();
    }
}

header('Location: index.php');
exit();
