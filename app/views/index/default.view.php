<?php require_once VIEWS_PATH . 'partial/header.php'; ?>
<div class="container">
    <aside class="sidebar active">         
        <?php if (isset($_SESSION['user_info'])): 
            $user_info = $_SESSION['user_info'];
        ?>
        <div class="user-info">
            <form id="avatar-form" action="<?= htmlspecialchars(PUBLIC_PATH) ?>/index/updateavatar" method="post" enctype="multipart/form-data">
                <div class="avatar">
                    <img id="avatar-img" class="avatar-img" src="<?= htmlspecialchars(PUBLIC_PATH) ?>/uploads/<?= htmlspecialchars($user_info['avatar'] ?? 'default_avatar.png'); ?>?t=<?= time(); ?>" alt="Avatar">
                    <div class="camera-icon" onclick="document.getElementById('avatar-input').click();">    
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <input type="file" id="avatar-input" name="avatar" style="display: none;" onchange="uploadAvatar()">
                <input type="hidden" name="userId" value="<?= htmlspecialchars($user_info['id']); ?>">
            </form>
            <p><b>Username:</b> <?= htmlspecialchars($user_info['username']); ?></p>
            <p><b>ID:</b> <?= htmlspecialchars($user_info['id']); ?></p>
            <p><b>No.Tasks:</b> <?= count($allTasks ?? []); ?></p>
        </div>
        <?php else: ?>
        <div class="user-info">
            <div class="avatar">
                <img class="avatar-img" src="<?= PUBLIC_PATH ?>/assets/img/index.jpg" alt="">
                <div class="camera-icon">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <p><b><em>Join To Save Your Work</em></b></p>
            <div class="auth-links">
                <a href="<?= PUBLIC_PATH ?>/auth/login" id="login-side">Login</a>
                <a href="<?= PUBLIC_PATH ?>/auth/signup" id="signup-side">Sign Up</a>
            </div>
        </div>
        <?php endif; ?>
    </aside>
    <main class="main-content expanded">
        <div class="note-form-container container">
            <form action="<?= PUBLIC_PATH ?>/index/addtask" method="post" class="note-form" id="note-form">
                <h1>Note App</h1>
                <input type="text" name="title" placeholder="Title" id="note-title" required>
                <textarea rows="5" name="description" placeholder="Description" id="note-description" required></textarea>
                <input type="hidden" name="id" value="<?= htmlspecialchars($user_info['id'] ?? '') ?>">
                <button type="submit" id="add-note">Add Note</button>
                <input type="hidden" id="session-status" value="<?= isset($_SESSION['user_info']) ? 'active' : 'inactive' ?>">
                <?php 
                    if (isset($_SESSION['empty_input'])) {
                        $errors = $_SESSION['empty_input'];
                        echo '<br><p class="error-login">' . htmlspecialchars($errors) . '!</p>';
                        unset($_SESSION['empty_input']);
                    }
                ?>
            </form>
        </div>
        <div class="notes-container container">
            <a href="<?= PUBLIC_PATH ?>/index/deleteAll" id="clear-notes" onclick="<?php if (empty($allTasks)): ?> return confirm('There Is No Any Note For Deleting'); <?php else: ?> return confirm('Alert - You Want Delete All Notes From List'); <?php endif; ?>">Clear All Notes</a>
            <div class="notes" id="unfinished-notes">
                <h2>Active Notes</h2>
                <?php if (!empty($allTasks)): ?>
                    <?php foreach($allTasks as $task): ?>
                        <?php if(!$task['completed']): ?>
                            <div class="note-item" id="task-<?= htmlspecialchars($task['id']) ?>">
                                <h3><?= htmlspecialchars($task['title']) ?></h3>
                                <p><?= htmlspecialchars($task['description']) ?></p>
                                <div class="actions">
                                    <div class="dates">
                                        <span>Created at: <?= htmlspecialchars($task['created_at']) ?></span><br>
                                        <span>Updated at: <?= htmlspecialchars($task['updated_at']) ?></span>
                                    </div>
                                    <div>
                                        <form action="<?= PUBLIC_PATH . DS ?>index/updateTask" method="post">
                                            <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                                            <input type="hidden" name="user_session_id" value="<?= htmlspecialchars($user_info['id'] ?? '') ?>">
                                            <button type="submit" class="update"><i class="fas fa-edit"></i></button>
                                        </form>
                                        <a class="delete" href="<?= PUBLIC_PATH . DS ?>index/deleteTask/<?= htmlspecialchars($task['id'] ?? '') ?>" onclick="return confirm('Do You Want To Delete This Task!');"><i class="fas fa-trash"></i></a>
                                        <a class="complete" href="<?= PUBLIC_PATH . DS ?>index/completedTask/<?= htmlspecialchars($task['id'] ?? '')?>"><i class="fas fa-check"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No active notes found.</p>
                <?php endif; ?>
            </div>
            <div class="notes" id="finished-notes">
                <h2>Finished Notes</h2>
                <?php if (!empty($allTasks)): ?>
                    <?php foreach($allTasks as $task): ?>
                        <?php if($task['completed']): ?>
                            <div class="note-item" id="task-<?= htmlspecialchars($task['id']) ?>">
                                <h3><?= htmlspecialchars($task['title']) ?></h3>
                                <p><?= htmlspecialchars($task['description']) ?></p>
                                <div class="actions">
                                    <form action="<?= PUBLIC_PATH . DS ?>index/updateTask" method="post">
                                        <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                                        <input type="hidden" name="user_session_id" value="<?= htmlspecialchars($user_info['id'] ?? '') ?>">
                                        <button type="submit" class="update"><i class="fas fa-edit"></i></button>
                                    </form>
                                    <a class="delete" href="<?= PUBLIC_PATH . DS ?>index/deleteTask/<?= $task['id'] ?>"  onclick="return confirm('Do You Want To Delete This Task!');" ><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No finished notes found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
<?php require_once VIEWS_PATH . 'partial/footer.php'; ?>
