<?php
$page_title = 'Login - The Royal';
require_once 'config/database.php';
require_once 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if (isset($user['role']) && $user['role'] === 'admin') {
                unset($_SESSION['intended_url']);
                header('Location: admin/dashboard.php');
                exit();
            }

            $redirect = $_SESSION['intended_url'] ?? 'index.php';
            unset($_SESSION['intended_url']);
            header('Location: ' . $redirect);
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>

<div class="container">
    <div class="form-container">
        <h2 class="form-title">Welcome Back</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Registration successful! Please login.</div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-input"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
            </div>

            <button type="submit" class="btn btn-primary form-submit">Login</button>
        </form>

        <p class="text-center mt-3">
            Don't have an account?
            <a href="register.php" class="text-accent">Register here</a>
        </p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>