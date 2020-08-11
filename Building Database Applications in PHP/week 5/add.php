<?php
session_start();

require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All values are required';
        header("Location: add.php");
        return;
    } elseif (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = "Year must be numeric";
        header("Location: add.php");
        return;
    } elseif (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: add.php");
        return;
    } else {
      $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
      $stmt->execute(array(
              ':mk' => $_POST['make'],
              ':md' => $_POST['model'],
              ':yr' => $_POST['year'],
              ':mi' => $_POST['mileage'])
      );
      $_SESSION['success'] = "Record added";
      header("Location: index.php");
      return;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>ASMITHA B's Automobile Tracker</title>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>
<?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
?>
<form method="post">
<p>Make:
<input type="text" name="make"/></p>
<p>Model:
<input type="text" name="model"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
