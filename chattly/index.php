<?php
require("connection.php");
session_start();

// Handle message submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
  $sender = $_SESSION['username'];
  $content = $_POST['message'];

  $query = "INSERT INTO messages (sender, content) VALUES ('$sender', '$content')";
  mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!--Ads paused-->
  <!--<meta name="monetag" content="2629716a11347be49f8738acadb0fd7e">-->
  <!--<script src="https://alwingulla.com/88/tag.min.js" data-zone="40943" async data-cfasync="false"></script>-->
  <!---->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php //title
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    echo "<title> Chattly - Chats</title>";
  } else {
    echo "<title> Chattly - Login or Register </title>";
  }
  ?>
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />
  
 
</head>

<body>

  <header>
    <h2>Chattly<span> - by areg</span></h2>
    <nav>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
    </nav>
    <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      echo "
         <div class='user'> 
          $_SESSION[username] - <a href='logout.php'>Logout</a> 
         </div>
        ";
    } else {
      echo "
          <div class='sign-in-up'>
            <button type='button' onclick=\"popup('login-popup')\">LOGIN</button>
           <button type='button' onclick=\"popup('register-popup')\">REGISTER</button>
          </div>
        ";
    }
    ?>
  </header>

  <!-- login form -->
  <div class="popup-container" id="login-popup">
    <div class="popup">
      <form method="POST" action="login_register.php">
        <h2>
          <span>USER LOGIN</span>
          <button type="reset" onclick="popup('login-popup')">X</button>
        </h2>
        <input type="text" placeholder="E-mail or Username" name="email_username">
        <input type="text" placeholder="Password" name="password">
        <button type="submit" class="login-btn" name="login">LOGIN</button>
      </form>
    </div>
  </div>

  <!-- register form -->
  <div class="popup-container" id="register-popup">
    <div class="register popup">
      <form method="POST" action="login_register.php">
        <h2>
          <span>USER REGISTER</span>
          <button type="reset" onclick="popup('register-popup')">X</button>
        </h2>
        <input type="text" placeholder="Full Name" name="fullname">
        <input type="text" placeholder="Username " name="username">
        <input type="email" placeholder="E-mail" name="email">
        <input type="text" placeholder="Password" name="password">
        <button type="submit" class="register-btn" name="register">REGISTER</button>
      </form>
    </div>
  </div>

  <!-- body -->
<div class="message-section">
  <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
     ?>
      <div id="messageContainer" class="message-container">
        <?php
        $messageQuery = "SELECT * FROM messages ORDER BY timestamp DESC LIMIT 70";
        $messageResult = mysqli_query($con, $messageQuery);

       while ($row = mysqli_fetch_assoc($messageResult)) {
          echo '<div class="message-tile">';
          echo '<div class="message-sender"><b> • ' . htmlspecialchars($row["sender"]) . '</b></div>';
          echo '<div class="message-content"> ' . htmlspecialchars($row["content"]) . '</div>';
          echo '</div> <br>';
        }
        ?>
     </div>
    <?php
    } 

    // if not logined
    else {    
       echo "<h1 style='text-align:center; margin-top: 350px ;'> Login first to chat. <h1> ";
       echo "<p style='text-align:center; font-size:25px ;'> <br> Also follow on : <p> ";
       echo "<div class='social-logos' style='text-align:center;'>
          <a href='https://www.facebook.com/aprimregmi0' target='_blank'><i style='color:#0165E1;' class='fa-brands fa-facebook'></i></a>
          <a href='https://np.linkedin.com/in/aprimregmi0'target='_blank'><i style='color:#0E4995;' class='fa-brands fa-linkedin'></i></a>
        </div>";
     }
  ?>

  

  <!-- input field for sending messages -->
  <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      echo '
            <div class="fixed-input">
              <input type="text" id="messageInput" placeholder="Type your message...">
              <button onclick="sendMessage()">Send</button>
            </div>
          ';
    }
  ?>

  <script>
    // Set the message container to scroll to the bottom
    var messageContainer = document.getElementById('messageContainer');
    messageContainer.scrollTop = messageContainer.scrollHeight;

    // login register popup
    function popup(popup_name) {
      get_popup = document.getElementById(popup_name);
      if (get_popup.style.display == "flex") {
        get_popup.style.display = "none";
      } else {
        get_popup.style.display = "flex";
      }
    }

    // send to database
    function sendMessage() {
      var messageInput = document.getElementById('messageInput').value.trim();

      if (message !== '') {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            // Optionally handle the server response
            location.reload();
          }
        };
        xhr.send('message=' + encodeURIComponent(message));

        // Clear the input field after sending the message
        messageInput.value = '';
      }
    }
    setInterval(function () {
      location.reload();
    }, 100000);//refreshing page every second
    
  </script>

</body>

</html>
