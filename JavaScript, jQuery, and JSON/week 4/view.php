<?php // Do not put any HTML above this line
session_start();
require_once "pdo.php";

// Make sure the REQUEST parameter is present
if (! isset($_REQUEST['profile_id'] ) ) {
    $_SESSION['error'] = "Missing profile_id";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare('SELECT * FROM Profile where profile_id = :prof');
$stmt->execute(array(':prof' => $_REQUEST['profile_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM Position WHERE profile_id = :prof ORDER BY rank');
$stmt->execute(array(':prof' => $_REQUEST['profile_id']));
$positions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM Education
                       JOIN Institution
                       ON Education.institution_id = Institution.institution_id
                       WHERE profile_id = :prof ORDER BY rank');
$stmt->execute(array(':prof' => $_REQUEST['profile_id']));
$educations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "head.php"; ?>
<title>ASMITHA B's Profile View</title>
</head>
<body>
<div class="container">
<h1>Profile information</h1>
<p>First Name: <?php echo(htmlentities($profile['first_name'])); ?></p>
<p>Last Name: <?php echo(htmlentities($profile['last_name'])); ?></p>
<p>Email: <?php echo(htmlentities($profile['email'])); ?></p>
<p>Headline:<br/> <?php echo(htmlentities($profile['headline'])); ?></p>
<p>Summary: <br/><?php echo(htmlentities($profile['summary'])); ?></p>
<p>Education: <br/><ul>
<?php
foreach ($educations as $education) {
    echo('<li>' . htmlentities($education['year']) . ': ' . htmlentities($education['name']) . '</li>');
} ?>
</ul></p>
<p>Position: <br/><ul>
<?php
foreach ($positions as $position) {
    echo('<li>'. htmlentities($position['year']) . ': ' . htmlentities($position['description']) .'</li>');
} ?>
</ul></p>
<a href="index.php">Done</a>
</div>
</body>
</html>
