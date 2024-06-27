<?php use TODO\App\Lib\SessionHdlr; 
$s = new SessionHdlr();
$s->sessionHandel();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/assets/css/index.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/all.min.css"> <!-- FontAwesome CSS -->
</head>
<body>
    <nav class="navbar">
        <div class="toggle-sidebar">☰</div>
        <?php if (empty($_SESSION['user_info'])): ?>
            <div class="auth-links">
                <a href="<?= PUBLIC_PATH ?>/auth/login" id="login">Login</a>
                <a href="<?= PUBLIC_PATH ?>/auth/signup" class="sign-b" id="signup">Sign Up</a>
            </div>
        <?php else: ?>
            <div class="auth-links">
                <a href="<?= PUBLIC_PATH ?>/auth/logout" class="sign-b" id="signup">Log out</a>
            </div>
        <?php endif; ?>
    </nav>
