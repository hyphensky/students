<?php
class Student
{
    public string $name;
    public string $surname;
    public string $pass;
    public string $email;
    public ?int $byear;
    public ?int $points;
    public string $place;
    public string $group;
    public string $sex;

    function __construct(
      string $name, 
      string $surname, 
      string $group, 
      string $email, 
      string $place, 
      ?int $byear, 
      ?int $points, 
      string $sex
    ) {
      $this->name = $name;
      $this->surname = $surname;
      $this->group = $group;
      $this->email = $email;
      $this->place = $place;
      $this->byear = $byear;
      $this->points = $points;
      $this->sex = $sex;
    }

    public function addStudent($pdo) : string
    {
      $this->pass = bin2hex(random_bytes(20));
      $string = "INSERT INTO Students VALUES (?,?,?,?,?,?,?,?,?)";
      $stmt = $pdo->prepare($string);
      $stmt->execute([
        $this->name, 
        $this->surname, 
        $this->sex, 
        $this->group, 
        $this->place, 
        $this->email, 
        $this->byear, 
        $this->points,
        $this->pass
      ]);
      return $this->pass;
    }

    public function updStudent($pdo, string $hash) : void
    {
      $string = "UPDATE Students SET `name` = ?, surname = ?,sex = ?,`group` = ?,
      place = ?,email = ?,byear = ?,points = ? WHERE pass = '$hash'";
      $stmt = $pdo->prepare($string);
      $stmt->execute([
        $this->name, 
        $this->surname, 
        $this->sex, 
        $this->group, 
        $this->place, 
        $this->email, 
        $this->byear, 
        $this->points,
      ]);
    }

}