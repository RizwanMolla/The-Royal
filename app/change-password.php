<?php
$page_title = 'Change Password';
$body_class = 'auth-page';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

// Redirect if not logged in
if (!is_logged_in()) {
    header('Location: /app/login.php');
    exit;
}

$user_id = get_user_id();
$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // --- Validation ---
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $errors[] = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $errors[] = 'New passwords do not match.';
    } elseif (strlen($new_password) < 8) {
        $errors[] = 'New password must be at least 8 characters long.';
    }

    if (empty($errors)) {
        try {
            global $pdo;

            // Fetch current user's password hash
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => $user_id]);
            $user = $stmt->fetch();

            // Verify current password
            if ($user && password_verify($current_password, $user['password'])) {
                // Hash the new password
                $new_password_hash = password_hash($new_password, PASSWORD_ARGON2ID);

                // Update the password in the database
                $update_stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                if ($update_stmt->execute(['password' => $new_password_hash, 'id' => $user_id])) {
                    $success_message = 'Your password has been changed successfully!';
                } else {
                    $errors[] = 'Failed to update password. Please try again.';
                }
            } else {
                $errors[] = 'Incorrect current password.';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error. Please try again later.';
            // In a real app, you would log this error.
            // error_log($e->getMessage());
        }
    }
}
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title"><?php echo $page_title; ?></h1>
        <p class="page-subtitle">Manage your account security.</p>
    </div>
</div>

<div class="container">
    <div class="form-container">
        <form action="/app/change-password.php" method="POST" novalidate>
            <h2 class="form-title">Change Your Password</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-input" required>
            </div>

            <button type="submit" class="btn btn-primary form-submit">Update Password</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>