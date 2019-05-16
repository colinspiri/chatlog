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
  if($toUserFirstName == "") {
    print "<h2> No user found with username '".$toUsername."'. </h2>";
    return;
  }
  print "<h2> Welcome back, $toUserFirstName! </h2>";

  // get messageIDs
  $sql = "SELECT * FROM messageRecipients WHERE toUserID = '$toUserID' ";
  $statement = $conn -> query( $sql );
  if($statement -> rowCount() == 0) {
    print "<br> <br> <h3> It looks like you haven't recieved any messages yet. Lame. </h3>";
    return;
  }
  else {
    print "<h3> Here are the messages you have recieved. </h3>";
  }

  // iterate through message IDs and show the message's information from messages table
  print "<div class='messageContainer'>";
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
    // format response
    print "<div class='message'>";
    print "<div class='person'>".$usersRow["username"]." &#8594 you </div>";
    print "<div class='subject'>".$messagesRow["subject"]."</div>";
    print "<div class='body'>".$messagesRow["body"]."</div>";
    print "</div>";
  }
  print "</div>";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
