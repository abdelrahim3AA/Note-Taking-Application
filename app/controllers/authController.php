<?php
declare(strict_types = 1);
namespace TODO\App\Controllers;
use PDOException;
use TODO\App\Controllers\AbstructController;
use TODO\App\models\Authmodel;
use TODO\App\LIB\Sessionhdlr;
use TODO\App\models\Usermodel;
class AuthController extends AbstructController {

    public function loginAction() {
        $this->_view(); 
    }

    public function signupAction() {
        $this->_view();
    }

    public function loginValidAction() {
        $s = new Sessionhdlr();
        $s->sessionHandel();
            
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $pwd = trim($_POST['password']);
            
            $authModel = new Authmodel();
            $userInfo = $authModel->getUserByEmail($email);
            if ($userInfo && password_verify($pwd, $userInfo['password'])) {

                $_SESSION['user_info'] = ['username' => $userInfo['username'], 'avatar' => $userInfo['avatar'], 'id' => $userInfo['id']];
                // $this->_view(VIEWS_PATH . '/index' . '/default.view.php', $res['id']);
                header('location: '. PUBLIC_PATH . '/index/default/' . $userInfo['id']);
                exit;
            } else {
                
                $errorMsg = "Email Or Password Or Both Are Not Valid!";
                $_SESSION['errors_login'] = $errorMsg;
                header('Location: ' . $_SERVER["HTTP_REFERER"]);
                exit;
            }   
        }
    }
    

    public function signupValidAction() {
        // $_SESSION['user_info']['id'];exit;
        $errors = [];
        // $fileName
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username   = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $pwd        = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                
                $uploadedFile = $_FILES['avatar'];
                $fileName = rand(1, 99999) . basename($uploadedFile['name']);
                $uploadDir =  'uploads/';
                $targetFilePath = $uploadDir . $fileName;
                // var_dump($targetFilePath);die;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // var_dump(is_dir($uploadDir));die;
                if (move_uploaded_file($uploadedFile['tmp_name'], $targetFilePath)) {
                    $flag = true;
                }
            }
        
        
            try {
                if (empty($username) || empty($email) || empty($pwd)) {
                    $errors['input_field'] = 'All Feild Are Required';
                }
            
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['$email_invalid'] = 'Email Is Not Valid';
                }
                
                $auth = new Authmodel();
                $emailRes    = $auth->isEmailRegistered($email);
                $usernameRes = $auth->isUsernameTaken($username);
                
                if ($emailRes) {
                    $errors['email_registered'] = "Email Alredy Registered";
                }

                if ($usernameRes) {
                    $errors['username_taken'] = "Username Is Taken";
                } elseif (strlen($username) < 8) {
                    $errors['username_short'] = "Username Must Be More Than 8 Chars";
                }

                if (strlen($pwd) < 8) {
                    $errors['password_short'] = "Password Must Be More Than 8 Chars";
                }

                
                $s = new Sessionhdlr();
                $s->sessionHandel();
                if ($errors || !$flag) {
                    
                    $_SESSION['errors_signup'] = $errors;
                    header('Location: ' . $_SERVER["HTTP_REFERER"]);
                    exit;
                } else {
                    $res = $auth->addUserInfo($username, $email, $pwd, $fileName);
                    if ($res) {
                        $userModel = new Usermodel();
                        $res = $userModel->getUserId($username);
                        $id = (int) $res['id'];
                        $_SESSION['user_info'] = ['username' => $username, 'email' => $email, $pwd, 'avatar' => $fileName, 'id' => $id];
                        $_SERVER['REQUEST_URI'];
                        header('location: '. PUBLIC_PATH . '/index/default/' . $id);
                        exit;
                    } else {
                        print "Error in SQL QUERY";
                    }
                    
                }
            } catch (PDOException $e) {
                echo "Query Is Not valid". $e->getMessage();
            }
        }
        
    }

    public function logoutAction() {
        // Destroy the session
        SessionHdlr::sessionDestroy();

        // Clear cookies related to the session if any
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Redirect to the default page
        header('Location: ' . PUBLIC_PATH . '/index/default'); // Adjust this URL based on your application
        exit;
    }

}