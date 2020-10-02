<?php
class AuthController {
    function loginAction() {
        global $confArray;
        echo json_encode([Auth::getInstance()->verifyUser($_POST['email'], $_POST['hash'])]);
    }
    function registerAction() {
        global $confArray;
        $this->status = true;
        $this->error = [];
        $this->data = [];
        foreach($_POST as $key => $value) {
            switch($key) {
                case "email":
                    $this->verifyEmail($key, htmlspecialchars($value));
                break;
                case "hash":
                    $this->verifyHash($key, htmlspecialchars($value));
                break;
                default:
                    $this->verifyText($key, htmlspecialchars($value));
                break;
            }
        }
        if ($this->status) {
            new User($this->data);
            echo json_encode([true]);
        } else {
            echo json_encode([false, $this->error]);
        }
    }
    function logoutAction() {
        global $confArray;
        unset($_SESSION['user_id']);
        unset($_SESSION['auth']);
        Auth::getInstance()->logout();
        header("Location: http://" . $confArray['base_url']);
    }
    private function verifyText($key, $value) {
        $tmp = strlen($value) > 2;
        $this->status = $tmp & $this->status;
        if ($tmp) {
            $this->data[$key] = $value;
        } else {
            array_push($this->error, $key);
        }
    }
    private function verifyHash($key, $value) {
        $tmp = strlen($value) == 128;
        $this->status = $tmp & $this->status;
        if ($tmp) {
            $this->data['salt'] = User::hexString(16);
            $this->data[$key] =  User::hashPW($value, $this->data['salt']);
        } else {
            array_push($this->error, $key);
        }
    }
    private function verifyEmail($key, $value) {
        $tmp = filter_var($value, FILTER_VALIDATE_EMAIL);
        $this->status = $tmp && $this->status;
        if ($tmp) {
            $this->data[$key] = $value;
        } else {
            array_push($this->error, $key);
        }
    }
}
?>
