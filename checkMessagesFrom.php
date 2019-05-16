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
  if($fromUserFirstName == "") {
    print "<h2> No user found with username '".$fromUsername."'. </h2>";
    return;
  }
  print "<h2> Welcome back, $fromUserFirstName! Here are the messages you have sent to others. </h2>";

  // get messages
  $sql = "SELECT * FROM messages WHERE fromUserID = '$fromUserID' ";
  $statement = $conn -> query( $sql );

  print "<style> th, td {border: 1px solid black; padding: 7px;} </style>";

  // iterate through message IDs and show the message's information from messages table
  print "<div class='messageContainer'>";
  foreach ($statement as $row) {
    print "<div class='message'>";

    // get toUserIDs from messageID
    $messageID = $row['messageID'];
    $sqlRecipients = "SELECT * FROM messageRecipients WHERE messageID = '$messageID' ";
    $statementRecipients = $conn -> query( $sqlRecipients );

    // for each userID, print username
    print "<div class='person'> ";
    foreach ($statementRecipients as $rowRecipients) {
      $toUserID = $rowRecipients['toUserID'];
      $sqlUsers = "SELECT * FROM users WHERE userID = '$toUserID' ";
      $statementUsers = $conn -> query( $sqlUsers );
      $rowUsers = $statementUsers -> fetch();
      print "you &#8594; ".$rowUsers['username']."<br>";
    }
    print "</div>";
    print "<div class='subject'>".$row["subject"]."</div>";
    print "<div class='body'>".$row["body"]."</div>";
    print "</div>";
  }
  print "</div>";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
