<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ASMITHA B f2752d78</title>
  </head>
  <body>
    <h1>Welcome to my guessing game</h1>
    <p>
      <?php
        $correct_number = 37;
        //print_r($_GET);
        $guess = $_GET['guess'];
        //echo var_dump($guess);
        if(! isset($_GET['guess']))
              echo "Missing guess parameter";
        else {
          if($guess === "") {
            echo "Your guess is too short";
          }
          elseif(! is_numeric($guess)) {
            echo "Your guess is not a number";
          }
          elseif($guess < $correct_number) {
            echo "Your guess is too low";
          }
          elseif($guess > $correct_number) {
            echo "Your guess is too high";
          }
          elseif($guess == $correct_number) {
            echo "Congratulations - You are right";
          }
        }
      ?>
    </p>
  </body>
</html>
