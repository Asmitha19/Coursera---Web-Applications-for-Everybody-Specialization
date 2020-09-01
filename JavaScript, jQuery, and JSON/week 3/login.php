<?php // Do not put any HTML above this line
session_start();
require_once "pdo.php";


if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';

// Check to see if we have some POST data, if we do process it
if (isset($_POST['email']) && isset($_POST['pass'])) {
      $check = hash('md5', $salt.$_POST['pass']);
      $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
      $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      /*
        Since we are checking if the stored hashed password matches the hash computation of the user-provided password,
        If we get a row, then the password matches, if we don't get a row (i.e. $row is false) then the password did not match.
        If he password matches, put the user_id value for the user's row into session as well as the user's name:
      */
      if ( $row !== false ) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        // Redirect the browser to index.php
        header("Location: index.php");
        return;
      }
      else {
        $_SESSION["error"] = "Incorrect password";
        error_log("Login fail ".$_POST['email']." $check");
        header("Location: login.php");
        return;
      }
}
// Fall through into the View
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php";
      require_once "util.php";
?>
<title>ASMITHA B's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
flashMessages();
?>
<form method="POST" action="login.php">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find an account and password hint
in the HTML comments.
<!-- Hint:
The account is umsi@umich.edu
The password is php123
 -->
</p>
<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>

</div>
</body>
