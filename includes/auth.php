<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_auth()
{
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
        header('Location: /the-royal/login.php');
        exit();
    }
}

function check_admin()
{
    check_auth();
    if ($_SESSION['role'] !== 'admin') {
        header('Location: /the-royal/index.php');
        exit();
    }
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function is_admin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function get_user_id()
{
    return $_SESSION['user_id'] ?? null;
}

function get_user_name()
{
    return $_SESSION['user_name'] ?? 'Guest';
}
