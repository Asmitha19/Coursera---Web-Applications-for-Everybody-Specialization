<?php
require_once "pdo.php";

$failure = false;
$success = false;

if (!isset($_GET['name'])) {
    die("Name parameter missing");
} elseif (isset($_POST['logout']) && $_POST['logout'] == 'Logout') {
    header('Location: index.php');
} elseif (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $failure = 'Mileage and year must be numeric';
    } elseif (strlen($_POST['make']) < 1 ) {
        $failure = 'Make is required';
    } else {
      $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(
              ':mk' => htmlentities($_POST['make']),
              ':yr' => htmlentities($_POST['year']),
              ':mi' => htmlentities($_POST['mileage']))
      );
      $success = 'Record inserted';
    }
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Asmitha's Autos Page</title>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $_GET['name']; ?></h1>
<?php
if ($failure !== false) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">' . htmlentities($failure) . "</p>\n");
}
if ($success !== true) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">' . htmlentities($success) . "</p>\n");
}
?>

<form method="post">
<p>Make:
<input type="text" name="make"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
<br><br>
<table style="width:30%; text-align:center; border: 2px solid black" border="1">
<caption style="text-align:center">Automobiles</caption>
<?php
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo($row['make']);
    echo("</td><td>");
    echo($row['year']);
    echo("</td><td>");
    echo($row['mileage']);
    echo("</td></tr>\n");
}
?>
</table>
</div>
</body>
