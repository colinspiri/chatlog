<?php
//See original: https://www.w3schools.com/php/php_mysql_connect.asp
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "chatlog";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);

  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $username = $_GET['newUsername'];
  $password = $_GET['newPassword'];
  $first = $_GET['newFirstName'];
  $last = $_GET['newLastName'];
  $email = $_GET['newEmail'];
  $sql = "INSERT INTO users (username, password, firstName, lastName, email) VALUES('$username', '$password', '$first', '$last', '$email')";
  print "<h2> Welcome! </h2>";
  print "<h3> Thank you, $first. You will be hearing from us soon. Next, try sending a message. </h3>";
  $conn -> exec( $sql );
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
