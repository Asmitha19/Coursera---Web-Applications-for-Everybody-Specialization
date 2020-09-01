<!-- Assignment: Auto-Grader: Profiles, Positions, and Education
     Assignment specification: https://www.wa4e.com/assn/res-education/
     Sample solution: https://www.wa4e.com/solutions/res-education/
-->

<?php
session_start();

require_once "pdo.php";
require_once "util.php";

$stmt = $pdo->query("SELECT * FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>ASMITHA B's Resume Registry</title>
<?php require_once "head.php";?>
</head>
<body>
<div class="container">
<h1>ASMITHA B's Resume Registry</h1>
<?php
//require_once "util.php";
flashMessages();

if (isset($_SESSION['name'])) {
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    echo "<p><a href='login.php'>Please log in</a></p>";
}

if (! empty($rows)) {
    echo('<table style = "width:40%; text-align:left; border: 2px solid black;" border="1">'."\n");
    echo " <thead><tr>";
    echo "<th>Name</th>";
    echo " <th>Headline</th>";
    if (isset($_SESSION['name'])) {
        echo("<th>Action</th>");
    }
    echo " </tr></thead>";
    foreach ($rows as $row) {
        echo "<tr><td>";
        echo("<a href='view.php?profile_id=" . htmlentities($row['profile_id']) . "'>" . htmlentities($row['first_name']) . " " .  htmlentities($row['last_name'])  . "</a>");
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td>");
        if (isset($_SESSION['name'])) {
            echo("<td>");
            echo('<a href="edit.php?profile_id=' . htmlentities($row['profile_id']) . '">Edit</a>  <a href="delete.php?profile_id=' . htmlentities($row['profile_id']) . '">Delete</a>');
        }
        echo("</td></tr>\n");
    }
    echo "</table>";
}
else {
    echo 'No rows found';
}

if (isset($_SESSION['name'])) {
    echo '</br><p><a href="add.php">Add New Entry</a></p>';
}

?>

</div>
</body>
