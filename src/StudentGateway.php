<?php
class StudentGateway
{
    public function getAllStudents($pdo, int $st_per_page, string $sort, int $page = 1) : array
    {
      if ($page == 1) {
          $offset = 0;
      } else {
          $offset = $page * $st_per_page - $st_per_page;
      }
      $sort_list = array(
        'name_asc'   => '`name`',
        'name_desc'  => '`name` DESC',
        'sname_asc'   => 'surname',
        'sname_desc'  => 'surname DESC',
        'group_asc'  => '`group`',
        'group_desc' => '`group` DESC',
        'points_asc'   => 'points',
        'points_desc'  => 'points DESC',  
      );
      if (array_key_exists($sort, $sort_list)) {
        $order = $sort_list[$sort];
      } else {
        $order = $sort_list['points_desc'];
      }
      $string = "SELECT * FROM STUDENTS ORDER BY $order LIMIT $st_per_page OFFSET $offset";
      $stmt = $pdo->prepare($string);
      $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $result;
      }
  
    public function getStudent($pdo, string $hash) : array
    {
      $string = "SELECT * FROM STUDENTS WHERE pass = ? ";
      $stmt = $pdo->prepare($string);
      $stmt->execute([$hash]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    }
  
    public function getSearchItems($pdo, string $search) : array
    {
          $string = "SELECT * FROM STUDENTS WHERE `name` LIKE :search OR 
      surname LIKE :search OR `group` LIKE :search OR points LIKE :search 
      ORDER BY points";
      $search = "%$search%";
          $stmt = $pdo->prepare($string);
      $stmt->bindParam(':search', $search);
      $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $result;
      }
  
    public function getStudentCount($pdo) : int
    {
      $string = "SELECT COUNT(*) FROM STUDENTS";
          $result = $pdo->query($string)->fetchColumn();
          return $result;
    }
}