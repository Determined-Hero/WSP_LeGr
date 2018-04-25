<?php

$host = 'localhost';
$dbname = 'blogg';
$user = 'admin';
$password = 'ywd13d7lwbfaboo';

//Skapar ett attribut för vårt PDO-objekt
$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

// Inställningar till vårt PDO-objekt
$dsn = "mysql:dbname=$dbname;host=$host;charset=utf8mb4";

//Skapar PDO-objektet
$pdo = new PDO($dsn, $user, $password, $attr);

$sql = "SELECT p.ID, p.Slug, p.Headline, CONCAT(u.FName, ' ', u.LName)AS Name, p.Creation_time, p.Text FROM posts AS p JOIN users AS u ON u.ID = p.User_ID ORDER BY p.Creation_time DESC";

//Testar vår anslutning
if($pdo) {

  //Skapar vår model-array
  $model = array();

  foreach($pdo->query($sql) as $row) {
    $model += array(
      $row['ID'] =>  array(
        'slug' => $row['Slug'],
        'title' => $row['Headline'],
        'author' => $row['Name'],
        'date' => $row['Creation_time'],
        'text' => $row['Text']
      )
    );
  }

} else {
  print_r($pdo->errorInfo());
}
?>
