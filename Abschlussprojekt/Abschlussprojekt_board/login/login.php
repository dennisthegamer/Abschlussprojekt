
<?php

require "../function/functions.php";

myheader();

// Hiermit wird überprüft, ob der User auf der Submit "einlog" gedrückt hat, wenn ja passiert ein SQL - Abfrage ob die Daten korrekt sind.
if(isset($_POST["einlog"])){
    require "../function/connection.php";

    // Die SQL - Abfrage von wo sie die Daten beziehen soll.
    $sql = "SELECT * from user WHERE gruppe = :gruppe";

    $stmt = $dbh -> prepare($sql);
    // Zunächst wird erstmal die gruppe mit der Datenbank verglichen.    
    $stmt->bindParam(":gruppe", $_POST["gruppe"]);
    $_SESSION['gruppe'] = $gruppe;
    $stmt->execute();
    $count = $stmt->rowCount();
    
    // In der nachfolgenden if abfrage, wird das passwort überprüft
    if($count == 1){
      $row = $stmt->fetch();
      // Da das Passwort in der Datenbank als Hashwert gespeicht ist, muss es mit "passwort_verify" überprüft werden.
      if(password_verify($_POST["passwort"], $row["passwort"])){
        session_start();
        $_SESSION["gruppe"] = $row["gruppe"];
        // Wenn alles seine Richtigkeit hat, wird zu "start.php" gewechselt.
        header("Location: ../board/board.php");
        // Wenn nicht wird eins der beiden fehler ausgegeben. 1. Fehler: Falsches Passwort - 2. Fehler: Falscher gruppe
        } else{
        echo '<script type="text/javascript" language="Javascript"> alert("Login fehlgeschlagen falsches Passwort!"); </script>';
      }
    }else{
    echo '<script type="text/javascript" language="Javascript"> alert("Login fehlgeschlagen falscher Usernane!"); </script>';
    }
}

?>

<div id="login">
  <!-- Der nachstehende "form" beinhaltet das einlog formular -->
  <form action="login.php" style="max-width:500px;margin:auto" method="post">
    <h2 class="hanm">Anmelden</h2>
    <div class="eingabefeld">
      <i class="fa fa-user icon"></i>
      <input class="eingabefeld-text-login" type="text" placeholder="Gruppe" name="gruppe">
    </div>
    
    <div class="eingabefeld">
      <i class="fa fa-key icon"></i>
      <input class="eingabefeld-text-login" type="password" placeholder="Password" name="passwort">
    </div>

    <button type="submit" class="btn-login" name="einlog">Einloggen</button> <br>
  </form>
</div>

<?php
myFooter();
?>











