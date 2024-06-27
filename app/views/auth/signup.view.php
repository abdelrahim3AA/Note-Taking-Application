<?php 
    use TODO\App\Lib\Sessionhdlr;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/assets/css/signup.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/all.min.css"> <!-- FontAwesome CSS -->
</head>

<body>
    <div class="auth-container">
        <h1><a href="<?= PUBLIC_PATH ?>">Note App</a></h1>
        <form action="<?= PUBLIC_PATH ?>/auth/signupValid" method="post" class="auth-form" enctype="multipart/form-data">
            <h2>Sign Up</h2>
            <div class="avatar-upload">
                <label for="avatar">
                    <img id="avatar-preview" src="<?= PUBLIC_PATH ?>/assets/img/default-avatar.png" alt="Avatar Preview">
                    <span>Upload Avatar</span>
                    <input type="file" id="avatar" name="avatar" accept="image/*">
                </label>
            </div>
            <input type="text" id="u-name" name="username" placeholder="Username">
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Sign Up</button>
            <p class="to-signup">Already have an account? <a href="<?= PUBLIC_PATH ?>/auth/login">Login</a></p>
            <?php 
                $s = new Sessionhdlr();
                $s->sessionHandel();
                if (isset($_SESSION['errors_signup'])) {
                    $errors = $_SESSION['errors_signup'];
                    echo '<div class="error-login">';
                    foreach($errors as $error) {
                        echo '<p>' . $error . '</p>';
                    }
                    echo '</div>';
                } 
                unset($_SESSION['errors_signup']);
            ?>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultAvatar = '<?= PUBLIC_PATH ?>/assets/img/default-avatar.png';
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarInput = document.getElementById('avatar');

            avatarInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    avatarPreview.src = defaultAvatar;
                }
            });
        });
    </script>
</body>

</html>
