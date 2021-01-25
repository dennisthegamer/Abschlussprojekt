<?php
session_start();
require "../function/functions.php";
require "../function/connection.php";

myheader();
 // Mit dieser if abfrage wird sichergestellt das der User eingelogt ist, wenn nicht wird er zur "login" page weitergeleitet.
if(!isset($_SESSION["gruppe"])){
    header("Location: ../login/login.php");
}

// löschen von teilnehmer aus der Datenbank
if(isset($_GET['delbewo'])){ 
     $stmt = $dbh->prepare('DELETE FROM teilnehmer WHERE id = :id') ;
     $stmt->execute(array(':id' => $_GET['delbewo']));

     header('Location: teilnehmer.php?action=deleted');
     exit;
} 
?>

<!-- Die Warnungsausgabe für das löschen der Nachricht, ebenfalls muss sie bestätgt werden. -->
<script language="JavaScript" type="text/javascript">
     
     function delbewo(id, vname, nname, mitarb, nr, gruppe) {
          if (confirm("Sind sie sicher das sie folgenden Namen löschen wollen:  '" + vname + "'")) {
               window.location.href = 'teilnehmer.php?delbewo=' + id;
          }
     }
</script>

<!-- Formular zum eingeben des vor und nachnamen. -->
<form action="teilnehmer.php" method="POST">
     <div class="grob">
          <div class="ver">
               <h1 class="hanm">Bewohner & Mitarbeiter </h1>

                    <div class ="eingabefeld">
                         <i class="fa fa-send icon"></i>
                         <input class="eingabefeld-text" type="text" placeholder="Vorname" name = "vname"> 
                         <input class="eingabefeld-text" type="text" placeholder="Nachname" name = "nname">
                         <input type="checkbox" name="mitarb" id="mitarb"> Mitarbeiter 
                         <input class="eingabefel-text" type="number" placeholder="Telefonnr" name="nr">
                         
                    </div>
               <input type="submit" value="Eintragen" class="btn" name="teilsp">
    <br> <br>

    <!-- Ausgabe der Daten aus der Datenbank, mit einem löschen button -->
    <table>
          <tr>
               <th>ID</th>
               <th>Vorname</th>
               <th>Nachname</th>
               <th>Mitarbeiter</th>
               <th>Telefonnr</th>
               <th>Gruppe</th>
               <th>Befehle</th>
          </tr>
<?php
     
     $stmt = $dbh->query("SELECT id, vname, nname, mitarb, nr, gruppe FROM teilnehmer where gruppe = '$_SESSION[gruppe]' ORDER BY id");
     
     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['vname'].'</td>';
     echo '<td>'.$row['nname'].'</td>';
     echo '<td>'.$row['mitarb'].'</td>';
     echo '<td>'.$row['nr'].'</td>';
     echo '<td>'.$row['gruppe'].'</td>';
     
?>
          <td>
               <a href="javascript:delbewo('<?php echo $row['id'];?>',
               '<?php echo $row['vname'];?>',
               '<?php echo $row['nname'];?>',
               '<?php echo $row['mitarb'];?>',
               '<?php echo $row['nr'];?>',
               '<?php echo $row['gruppe'];?>
               ')">Löschen</a>
          </td>

<?php 
     echo '</tr>';
     }
?>
	</table>
<!-- dient zum eintragen der Daten in die Datenbank. -->
<?php

$vname = $_POST['vname'];
$nname = $_POST['nname'];
$mitarb = (isset($_POST['mitarb'])) ? 'Ja' : 'Nein';
$nr = $_POST['nr'];
$gruppe = $_SESSION['gruppe'];

if(isset($_POST['teilsp'])){

     $sql = "INSERT INTO teilnehmer (vname, nname, mitarb, nr, gruppe) VALUES (:vname, :nname, :mitarb, :nr, :gruppe)";
     $stmt = $dbh->prepare($sql);
     $stmt->bindValue(':vname', $vname);
     $stmt->bindValue(':nname',$nname);
     $stmt->bindValue(':mitarb',$mitarb);
     $stmt->bindValue(':nr',$nr);
     $stmt->bindValue(':gruppe',$gruppe);
     
     $stmt->execute();
     echo '<meta http-equiv="refresh" content="0; URL=teilnehmer.php">';
}
?>

<?php
myFooter();
?>