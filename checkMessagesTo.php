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

  // get toUserID
  $toUsername = $_GET["usernameTo"];
  $sql = "SELECT * FROM users WHERE username = '$toUsername' ";
  $statement = $conn -> query( $sql );
  $row = $statement -> fetch();
  $toUserID = $row['userID'];
  $toUserFirstName = $row['firstName'];
  print "<h1> Welcome back, $toUserFirstName! Here are the messages others have left for you. </h1>";

  // get messageIDs
  $sql = "SELECT * FROM messageRecipients WHERE toUserID = '$toUserID' ";
  $statement = $conn -> query( $sql );

  print "<style> th, td {border: 1px solid black; padding: 7px;} </style>";
  print "<table><tr><th>Subject</th><th>Body</th><th>From</th></tr>";

  // iterate through message IDs and show the message's information from messages table
  foreach ($statement as $row) {
    // get subject, body, fromUserID from messages table
    $messageID = $row['messageID'];
    $sql = "SELECT * FROM messages WHERE messageID = '$messageID' ";
    $messagesStatement = $conn -> query( $sql );
    $messagesRow = $messagesStatement -> fetch();
    // get fromUsername from users using fromUserID
    $fromUserID = $messagesRow['fromUserID'];
    $sql = "SELECT * FROM users WHERE userID = '$fromUserID' ";
    $usersStatement = $conn -> query( $sql );
    $usersRow = $usersStatement -> fetch();
    print "<tr>";
    print "<td>" .  $messagesRow['subject'] .  "</td>";
    print "<td>" .  $messagesRow['body'] .  "</td>";
    print "<td>" .  $usersRow['username'] .  "</td>";
    print "</tr>";
  }
  print "</table>";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
