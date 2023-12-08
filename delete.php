<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])) {
  header("Location: index.php");
  return;
}

$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->bindParam(":id", $id);
$statement->execute();

if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo "contact not found";
  return;
}

$statement = $conn->prepare("DELETE FROM contacts WHERE id = :id");
$statement->bindParam(":id", $id);
$statement->execute();

header("Location: home.php");