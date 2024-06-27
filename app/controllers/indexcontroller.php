<?php

namespace TODO\App\Controllers;
use TODO\App\Controllers\AbstructController;
use TODO\App\models\Taskmodel;
use TODO\App\Lib\Sessionhdlr;
use TODO\App\models\Usermodel;

class IndexController extends AbstructController
{
    public function sessionRun() {

        $s = new Sessionhdlr();
        $s->sessionHandel();
    }
    public function model()
    {
        return new Taskmodel();
    }
    public function defaultAction($_params) {
        $this->sessionRun();
        
        $userIdS = $_SESSION['user_info']['id'] ?? null;
        $userId = $_params[0] ?? null;

        if ($userIdS && $userId == $userIdS) {
            $allTasks = $this->model()->getAllTasks($userId);
            $this->_data['allTasks'] = $allTasks;
        } else {
            
            $this->_data['allTasks'] = [];
        }

        $this->_view();
    }

    public function deleteAllAction() {
        $action = $this->model(); 
        $action->deleteAll();
    }

    public function addtaskAction()
    {
        $action = $this->model();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

           
            // $title = htmlspecialchars($_POST['title']);
            // $description = htmlspecialchars($_POST['description']);

            $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
            $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
            $id = $_POST['id'];
            // var_dump($title, $description);die;
            if(empty($title) && empty($description)) {
                $this->sessionRun();
                $_SESSION['empty_input'] = "Two Filed Must Be Fill";
                header('Location: ' . $_SERVER["HTTP_REFERER"]);
                exit;
            } else {
                $action->addTask($title, $description, $id);
            }
        }

    }

    public function deleteTaskAction()
    {   
        $id = (int) array_shift($this->_params);
        $this->model()->deleteTask($id); 
    }

    public function updateTaskAction()
    {
        $id = (int) array_shift($this->_params);
        $task = $this->model()->getTask($id);
        $this->_data['task'] = $task;
        $this->_view();
        
    }

    public function updateTask2Action() {
        $action = $this->model();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_session_id = $_POST['user_session_id'];
            $newTitle = $_POST['title'];
            $newDescription = $_POST['description'];
            $id = $_POST['id'];
            $action->updateTask($newTitle, $newDescription, $id); 
            // var_dump($user_session_id);die;
            header("location: " . PUBLIC_PATH . '/index/default/' . $user_session_id);
            exit;
        }
    }

    public function completedTaskAction() {
        $id = (int) array_shift($this->_params);
        $action = $this->model(); 
        $action->completedTask($id); 
    }
    public function NotcompletedTaskAction() {
        $id = (int) array_shift($this->_params);
        $action = $this->model(); 
        $action->NotcompletedTask($id); 
    }

    /**public function apdateavatarAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'];
    
            // Check if file is uploaded
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = $_FILES['avatar'];
                $fileName = rand(1, 99999) . basename($uploadedFile['name']);
                $uploadDir = 'uploads/';
                $targetFilePath = $uploadDir . $fileName;
    
                // Log the upload directory and file path
                error_log("Upload directory: " . $uploadDir);
                error_log("Target file path: " . $targetFilePath);
    
                // Create upload directory if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                // Validate file type (allow only images)
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($uploadedFile['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    die('Invalid file type.');
                }
    
                // Move the uploaded file to the target directory
                if (move_uploaded_file($uploadedFile['tmp_name'], $targetFilePath)) {
                    error_log('File moved successfully to ' . $targetFilePath);
    
                    $userModel = new Usermodel();
                    if ($userModel->changeAvatar($fileName, $userId)) {
                        error_log('Database updated successfully for user ID: ' . $userId);
                        header('Location: ' . $_SERVER["HTTP_REFERER"]);
                        exit;
                    } else {
                        error_log('Database update failed for user ID: ' . $userId);
                        die('Failed to update avatar in the database.');
                    }
                } else {
                    error_log('Failed to move uploaded file.');
                    die('Failed to move uploaded file.');
                }
            } else {
                error_log('File upload error. Error code: ' . $_FILES['avatar']['error']);
                die('File upload error.');
            }
        } else {
            die('Invalid request method.');
        }
    }**/
   /* public function apdateavatarAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'];
    
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = $_FILES['avatar'];
                $fileName = rand(1, 99999) . basename($uploadedFile['name']);
                $uploadDir = 'uploads/';
                $targetFilePath = $uploadDir . $fileName;
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($uploadedFile['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid file type.']);
                    exit;
                }
    
                if (move_uploaded_file($uploadedFile['tmp_name'], $targetFilePath)) {
                    $userModel = new Usermodel();
                    if ($userModel->changeAvatar($fileName, $userId)) {
                        echo json_encode(['success' => true, 'newAvatar' => $fileName]);
                        exit;
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed to update avatar in the database.']);
                        exit;
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'File upload error.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
            exit;
        }
    }*/
    
    public function apdateavatarAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'];
    
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = $_FILES['avatar'];
                $fileName = rand(1, 99999) . basename($uploadedFile['name']);
                $uploadDir =  'uploads/';
                $targetFilePath = $uploadDir . $fileName;
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($uploadedFile['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    echo json_encode(['success' => false, 'error' => 'Invalid file type.']);
                    exit;
                }
    
                if (move_uploaded_file($uploadedFile['tmp_name'], $targetFilePath)) {
                    $userModel = new Usermodel();
                    if ($userModel->changeAvatar($fileName, $userId)) {
                        echo json_encode(['success' => true, 'newAvatar' => $fileName]);
                        // header('location: '. $_SERVER['REQUEST_URI']);
                        // header('location:' . $_SERVER['HTTP_REFERER']);
                    //   print "alert('please Login for save your changin')";
                        exit;
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed to update avatar in the database.']);
                        exit;
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'File upload error.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
            exit;
        }
    }
    
    
    
}
