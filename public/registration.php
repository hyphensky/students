<?php
require "../header.php";

$name = $surname = $sex = $group = $place = $email = "";
$points = $byear = null;
$regString = "";
$error = array();
$page_title = "Страница регистрации";
$buttonText = (isset($_COOKIE['logged'])) ?  "Обновить" : "Зарегистрироваться";
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $val = new Validator();
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $byear = (int) $_POST['byear'];
    $group = $_POST['group'];
    if (isset($_POST['place'])) {
        $place = $_POST['place'];
    }
    $email = $_POST['email'];
    $points = (int) $_POST['points'];
    if (isset($_POST['sex'])) {
        $sex = $_POST['sex'];
    }
    $logged = $_COOKIE['logged'] ?? null;
    $error['name'] = $val->validName($name);
    $error['surname'] = $val->validName($surname);
    $error['group'] = $val->validGroup($group);
    $error['email'] = $val->validMail($pdo, $email, $logged);
    $error['byear'] = $val->validBirthyear($byear);
    $error['points'] = $val->validPoints($points);
    if (isset($logged)) {
        $error['email'] = $val->validUser($pdo, $email, $logged);
    }
    foreach($error as $err) {
        if ($err != "") {
            $validation = false;
            break;
        } else {
            $validation = true;
        }
    }
    if (!$validation) {
        $regString = "Ошибка, исправьте данные";
    } else {
            $st = new Student($name, $surname, $group, $email, $place, $byear, $points, $sex);
            if (!isset($_COOKIE['logged'])) {
                $hash = $st->addStudent($pdo);
                $regString = "Вы были зарегистрированы, данные могут быть отредактированы позже";
                setcookie("logged", $hash, time()+(10*365*24*60*60), '/', null, false, true);
                header('Location: index.php');
                exit;
            } else {
                $st->updStudent($pdo, $_COOKIE['logged']);
                $regString = "Данные успешно обновлены";
            }
       } 
}
if (isset($_COOKIE['logged'])) {
    $page_title = "Личная страница";
    $stgw = new StudentGateway();
    $student = $stgw->getStudent($pdo, $_COOKIE['logged']);
} else {
        $obj = new Student($name, $surname, $group, $email, $place, $byear, $points, $sex);
        $student = (array) $obj;
}

include '../views/registration.phtml';
