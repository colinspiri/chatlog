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

  // get fromUserID
  $fromUsername = $_GET["usernameFrom"];
  $sql = "SELECT * FROM users WHERE username = '$fromUsername' ";
  $statement = $conn -> query( $sql );
  $row = $statement -> fetch();
  $fromUserID = $row['userID'];
  $fromUserFirstName = $row['firstName'];
  print "<h1> Welcome back, $fromUserFirstName! Here are the messages you have sent to others. </h1>";

  // get messages
  $sql = "SELECT * FROM messages WHERE fromUserID = '$fromUserID' ";
  $statement = $conn -> query( $sql );

  print "<style> th, td {border: 1px solid black; padding: 7px;} </style>";
  print "<table><tr><th>Subject</th><th>Body</th><th>To</th></tr>";

  // iterate through message IDs and show the message's information from messages table
  foreach ($statement as $row) {
    // print subject and body
    print "<tr>";
    print "<td>" .  $row['subject'] .  "</td>";
    print "<td>" .  $row['body'] .  "</td>";

    // get toUserIDs from messageID
    $messageID = $row['messageID'];
    $sqlRecipients = "SELECT * FROM messageRecipients WHERE messageID = '$messageID' ";
    $statementRecipients = $conn -> query( $sqlRecipients );

    // for each userID, print username
    foreach ($statementRecipients as $rowRecipients) {
      $toUserID = $rowRecipients['toUserID'];
      $sqlUsers = "SELECT * FROM users WHERE userID = '$toUserID' ";
      $statementUsers = $conn -> query( $sqlUsers );
      $rowUsers = $statementUsers -> fetch();
      print "<td>" .  $rowUsers['username'] .  "</td>";
    }
    print "</tr>";
  }
  print "</table>";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
