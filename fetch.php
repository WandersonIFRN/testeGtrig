<?php

//fetch.php;

$data = array();

if(isset($_GET["query"]))
{
 $connect = new PDO("mysql:host=localhost; dbname=testegtrigueiro", "root", "");

 $query = "
 SELECT numero FROM processo 
 WHERE numero LIKE '".$_GET["query"]."%' 
 ORDER BY numero ASC 
 LIMIT 15
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row["numero"];
 }
}

echo json_encode($data);

?>