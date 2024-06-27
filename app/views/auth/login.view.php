<?php 
    use TODO\App\Lib\Sessionhdlr;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/assets/css/login.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/all.min.css"> <!-- FontAwesome CSS -->
</head>

<body>
    <div class="container">
        
    </div>
    <div class="auth-container">
        <h1><a href="<?= PUBLIC_PATH ?>">Note App</a></h1>
        <form action="<?= PUBLIC_PATH ?>/auth/loginValid" method="post" class="auth-form">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit">Login</button>
            <p class="to-signup">Don't have an account? <a href="<?= PUBLIC_PATH ?>/auth/signup">Sign up</a></p>
            <?php 
                $s = new Sessionhdlr();
                $s->sessionHandel();
                if (isset($_SESSION['errors_login'])) {
                    $errors = $_SESSION['errors_login'];
                    echo '<div class="error-login">' . $errors . '</div>';
                } 
                unset($_SESSION['errors_login']);
            ?>
        </form>
    </div>
</body>

</html>
