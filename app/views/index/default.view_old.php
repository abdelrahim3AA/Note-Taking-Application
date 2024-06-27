<?php require_once VIEWS_PATH . DS . 'html' . DS . 'header.php'?>
<h4>hello</h4>
<div class="container">
    <h1>Todo List</h1>

    <form action="<?=PUBLIC_PATH . DS?>index/addtask" method="POST">
        <input type="text" name="title" placeholder="Enter task title">
        <textarea name="description" placeholder="Enter task description"></textarea>
        <button type="submit">Add Task</button>
    </form>

    <div class="task-list">
        <div class="title">
            <h2>My Tasks :</h2>
            <button class="clear_all">Clear All</button>
        </div>


            <?php foreach ($allTasks as $task): ?>
        <ul>
            <?php if (!$task['completed']): ?>
            <li>

                <span><b><?=$task['title'];?></b> <?=$task['description'];?></span>
                <p>Inserted at: <?=$task['created_at'];?></p>
                <p>Updated at: <?=$task['updated_at'];?></p>
                <div id="mine">
                <a class="update-btn" href="<?=PUBLIC_PATH . DS?>index\updateTask\<?=$task['id']?>">Update</a>
                <a class="delete-btn" href="<?=PUBLIC_PATH . DS?>index\deleteTask\<?=$task['id']?>">Delete</a>
                <a class="update-btn" href="<?=PUBLIC_PATH . DS?>index\completedTask\<?=$task['id']?>">Complete</a>
                </div>
            </li>
            <?php endif;?>
        </ul>
            <?php endforeach;?>

            <!-- Sample task -->

    </div>
    <div class="task-list">
        <div class="title">
            <h2>Completed Tasks: </h2>
            <button class="clear_all">Clear All</button>
        </div>


            <?php foreach ($allTasks as $task): ?>
        <ul>
            <?php if ($task['completed']): ?>
            <li>
                <span><b><?=$task['title'];?></b> <?=$task['description'];?></span>
                <p>Inserted at: <?=$task['created_at'];?></p>
                <p>Updated at: <?=$task['updated_at'];?></p>

                <a class="update-btn" href="<?=PUBLIC_PATH . DS?>index\NotcompletedTask\<?=$task['id']?>">Not Complete</a>
           </li>
            <?php endif;?>
        </ul>
            <?php endforeach;?>
</div>

<?php require_once VIEWS_PATH . DS . 'html' . DS . 'footer.php'?>
