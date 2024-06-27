<?php 
    use TODO\APP\models\Taskmodel;
   
    $t = new Taskmodel();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_session_id = $_POST['user_session_id'];
        $task = $t->getTask($_POST['taskId']);
        $task = !empty($task) ? $task[0] : null; // Check if $task is not empty
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Note</title>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/assets/css/update.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/assets/css/application.css"> <!-- Assuming this is your main application CSS -->
</head>

<body>
    <div class="auth-container">
        <form action="<?= PUBLIC_PATH ?>/index/updatetask2" method="post" class="auth-form">
            <h1>Update Note</h1>
            <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'] ?? '') ?>">
            <input type="hidden" name="user_session_id" value="<?= htmlspecialchars($user_session_id ?? '') ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= $task['title'] ?? '' ?>" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="5" placeholder="Enter description" required><?= $task['description'] ?? '' ?></textarea>
            </div>
            <button type="submit">Update Note</button>
        </form>
    </div>
</body>

</html>
