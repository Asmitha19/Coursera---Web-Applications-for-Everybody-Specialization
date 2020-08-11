<!-- Assignment: Autos with Post-Redirect
     https://www.wa4e.com/solutions/autosess/index.php-->

<?php
session_start();

require_once "pdo.php";

$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>ASMITHA B's Index Page</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>
<?php
    if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }

    if (! isset($_SESSION['name'])) {
        echo "<p>
              <a href='login.php'>Please log in</a>
              </p>
              <p>
              Attempt to <a href='add.php'>add data</a> without logging in
              </p>";
    }
    else {
        if (sizeof($rows) > 0) {
            echo('<table style = "width:40%; border: 2px solid black;" border="1">'."\n");
            echo '<thead><tr>';
            echo "<th>Make</th>";
            echo "<th>Model</th>";
            echo "<th>Year</th>";
            echo "<th>Mileage</th>";
            echo "<th>Action</th>";
            echo "</tr></thead>";
            foreach ($rows as $row) {
                  echo "<tr><td>";
                  echo(htmlentities($row['make']));
                  echo("</td><td>");
                  echo(htmlentities($row['model']));
                  echo("</td><td>");
                  echo(htmlentities($row['year']));
                  echo("</td><td>");
                  echo(htmlentities($row['mileage']));
                  echo("</td><td>");
                  echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / <a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                  echo("</td></tr>\n");
            }
            echo "</table>";
        }
        else {
            echo '<p>No rows found</p>';
        }
        echo '</br><p><a href="add.php">Add New Entry</a></p>
              <p><a href="logout.php">Logout</a></p>';
        }
?>

</div>
</body>
