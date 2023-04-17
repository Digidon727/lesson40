<?php
function debug($data)
{
    echo "<pre>" . print_r($data) . "</pre>";
}

function registration(): bool
{
    global $pdo;

    $login = !empty($_POST['login']) ? trim($_POST['login']) : '';
    $pass = !empty($_POST['pass']) ? trim(($_POST['pass'])) : '';

    if (empty($login) || empty($pass)) {
        $_SESSION['errors'] = 'Поле логин/пароль обязательны';
        return false;
    }

    $res = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ?");
    $res->execute([$login]);
    if ($res->fetchColumn()) {
        $_SESSION['errors'] = 'Данный логин уже используется';
        return false;
    }

    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $res = $pdo->prepare("INSERT INTO users(login, pass) value(?, ?)");
    if ($res->execute([$login, $pass])) {
        echo $_SESSION['success'] = 'Успешная регистрация';
        return true;
    } else {
        $_SESSION['errors'] = 'Ошибка регистрации';
        return false;
    }
}


function login(): bool
{
    global $pdo;

    $login = !empty($_POST['login']) ? trim($_POST['login']) : '';
    $pass = !empty($_POST['pass']) ? trim(($_POST['pass'])) : '';

    if (empty($login) || empty($pass)) {
        $_SESSION['errors'] = 'Поле логин/пароль обязательны';
        return false;
    }

    $res = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $res->execute([$login]);
    if (!$user = $res->fetch()) {
        $_SESSION['errors'] = 'Логин или пароль введены неверно';
        return false;
    }

    if (!password_verify($pass, $user['pass'])) {
        $_SESSION['errors'] = 'Логин или пароль введены неверно';
        return false;
    } else {
        $_SESSION['success'] = 'Успешная авторизовались';
        $_SESSION['user']['name'] = $user['login'];
        $_SESSION['user']['id'] = $user['id'];
        return true;
    }
}