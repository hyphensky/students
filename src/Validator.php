<?php
class Validator
{
  public function validName(string $val) : string
  {
    $res = preg_match('/^[A-Яa-яЁё\'-]{1,20}$/ui', $val);
    if (!$res) {
      return "Некорректное имя, введите от 1 до 20 букв кириллицей";
    } else {
      return "";
    }
  }

  public function validMail($pdo, string $val, ?string $logged) : string
  { 
   $mail = $pdo->quote($val);
   $res = $pdo->query("SELECT COUNT(*) FROM Students WHERE email = $mail")->fetchColumn();
   if ($res > 0 && !isset($logged)) {
      return "Выберите другой e-mail";
   }
   
   if (filter_var($val, FILTER_VALIDATE_EMAIL)) {
      return "";
   } else {
      return "Некорректный адрес e-mail";
   }
  }

  public function validGroup(string $val) : string
  {
    $res = preg_match('/^\w{2,5}$/u', $val);
    if (!$res) {
        return "Некорректное значение, требуется 2-5 символов";
    } else {
        return "";
    }
  }

  public function validPoints(int $val) : string
  {
    if (!ctype_digit((string)$val)) {
        return "Введите целое число баллов";
    } elseif ($val >= 0 && $val <= 300) {
        return "";
    } else {
        return "Введите баллы от 0 до 300";
    }
  }

  public function validBirthyear(int $val) : string
  {
    $res = preg_match('/^\d{4}$/', $val);
    if (!$res || $val < 1880 || $val > date('Y')) {
        return "Некорректный год рождения, введите год в виде 4 цифр";
    } else {
        return "";
    }
  } 
  
  public function validUser($pdo, string $val, ?string $logged) : string
  { 
    $mail = $pdo->quote($val);
    $pass = $pdo->query("SELECT pass FROM Students WHERE email = $mail")->fetchColumn();
    if (isset($logged) && $logged == $pass) {
      return "";
    } else {
      return "Введите свой e-mail";
    }
  }
}
