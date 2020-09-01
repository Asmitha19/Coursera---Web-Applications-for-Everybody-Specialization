<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM Profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_REQUEST['profile_id']));
    $_SESSION['success'] = 'Profile deleted';
    header( 'Location: index.php' ) ;
    return;
}

$stmt = $pdo->prepare("SELECT first_name, last_name FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_REQUEST['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Could not load profile';
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>ASMITHA B's Profile Delete</title>
<?php require_once "head.php"; ?>
</head>
<body>
<div class="container">
<h1>Deleting Profile</h1>
<form method="post" action="delete.php">
<p>First Name: <?= htmlentities($row['first_name']) ?></p>
<p>Last Name: <?= htmlentities($row['last_name']) ?></p>
<input type="hidden" name="profile_id" value="<?= htmlentities($_GET['profile_id']) ?>"/>
<input type="submit" name="delete" value="Delete">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
