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

  $fromUsername = $_GET['username'];
  $toUsername = $_GET['to'];
  $subject = $_GET['subject'];
  $body = $_GET['body'];

  // get fromUserID from users table
  $sql = "SELECT * FROM users WHERE username = '$fromUsername' ";
  $statement = $conn -> query($sql);
  $row = $statement -> fetch();
  $fromUserID = $row['userID'];
  // print "<h1> fromUserID: $fromUserID </h1>";

  // insert into messages table
  $sql = "INSERT INTO messages (subject, body, fromUserID) VALUES('$subject', '$body', '$fromUserID')";
  $conn -> exec( $sql );
  $messageID = $conn -> lastInsertId();
  // print "<h1> messageID: $messageID </h1>";

  // get toUserID from users table
  $sql = "SELECT * FROM users WHERE username = '$toUsername' ";
  $statement = $conn -> query($sql);
  $row = $statement -> fetch();
  $toUserID = $row['userID'];
  // print "<h1> toUserID: $toUserID </h1>";

  // insert into messageRecipients table
  $sql = "INSERT INTO messageRecipients (messageID, toUserID) VALUES('$messageID', '$toUserID')";
  $conn -> exec( $sql );
  print "<h1> Successfully transmitted message to $toUsername. </h1>";

}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
