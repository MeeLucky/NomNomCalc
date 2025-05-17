<?php 

function validateLogin($login) {
    // Проверка на разрешённые символы (a-z, A-Z, 0-9)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
        return "Логин должен состоять только из латиницы или цифр";
    } else {
        // Проверка длины (3-50 символов)
        if (strlen($login) < 3 || strlen($login) > 50) {
            return "Слишком короткий логин"; 
        } 
    }

    return "";
}

if(isset($_POST["signUp"])) {
    unset($_POST["signUp"]);

    $name = $_POST["name"];
    $login = $_POST["login"];
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    $validMsg = "";
    //валидация имени
    if(strlen($name) < 3) {
        $validMsg = "Слишком короткое имя"; 
    }

    //валидация логина
    if($validMsg == "") {
        $validMsg = validateLogin($login); 
    }

    //валидация пароля
    if($validMsg == "") {
        if(strlen($pass1) < 3) {
            $validMsg = "Слишком короткий пароль";
        } else {
            if (!preg_match('/^[a-zA-Z0-9]+$/', $pass1)) {
                $validMsg = "Пароль должен состоять только из латиницы или цифр";
            } else {
                if($pass1 != $pass2) {
                    $validMsg = "Пароли не совпадают";
                }
            }
        }
    }

    //создание пользователя
    if($validMsg == "") {
        $stmtGetUser = $dbh->prepare("SELECT id FROM users WHERE login = :login");
        $stmtGetUser->execute([':login' => $login]);
        $user = $stmtGetUser->fetch(PDO::FETCH_ASSOC);
        if($user == false) {
            //создаём пользователя
            try {
                $stmtInserUser = $dbh->prepare("INSERT INTO users (name, login, password) VALUES (:name, :login, :pass)");
                $stmtInserUser->execute([
                    ':name' => $name,
                    ':login' => $login,
                    ':pass' => password_hash($pass1, PASSWORD_DEFAULT)
                ]);
                    $resultMsg = "Регистрация успеша!<br>Вы можете войти по форме ниже.";
            } catch(PDOException $e) {
                $validMsg = "Ошибка: " . $e->getMessage();
            }

            if(stmtInserUser == ture) {
                $resultMsg = "Регистрация успеша!<br>Вы можете войти по форме ниже.";
            }
        } else {
            $validMsg = "Пользователь с таким логином уже существует";
        }
    }
}

if(isset($_POST["signIn"])) {
    unset($_POST["signIn"]);
    $log = $_POST["login"];
    $pass = $_POST["pass"];
    $validMsgLogin = "";		
    $stmtGetUser = $dbh->prepare(
        "SELECT id, name, login, password FROM users WHERE login = :login"
    );
    $stmtGetUser->execute([':login' => $log]);
    $user = $stmtGetUser->fetch(PDO::FETCH_ASSOC);
    if($user != false) {
        if(password_verify($pass, $user['password']) == true) {
            setcookie("user_id", $user["id"], time() + 60 * 60 * 24 * 354);//1 год
            setcookie("user_name", $user["name"], time() + 60 * 60 * 24 * 354);//1 год
        } else {
            $validMsgLogin = "Неправильный логин или пароль";
        }
    } else {
        $validMsgLogin = "Неправильный логин или пароль";
    }
    
}
?>