<?php
session_start();
require "../function/connection.php";
require "../function/functions.php";

myheader();
 // Mit dieser if abfrage wird sichergestellt das der User eingelogt ist, wenn nicht wird er zur "login" page weitergeleitet.
 if(!isset($_SESSION["gruppe"])){
    header("Location: ../login/login.php");
}

//  Löschen der telnr
if(isset($_GET['deltelnr'])){ 

	$stmt = $dbh->prepare('DELETE FROM telnr WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['deltelnr']));

     header('Location: telnr.php?action=deleted');
	exit;
} 
?>

<!-- Die Warnungsausgabe für das löschen einer Telefonnr, ebenfalls muss sie bestätgt werden. -->
<script language="JavaScript" type="text/javascript">
     
     function deltelnr(id, nr, gruppennr) {
          if (confirm("Sind sie sicher das sie folgende Nummer löschen wollen:  '" + gruppennr + "'")) {
               window.location.href = 'telnr.php?deltelnr=' + id;
          }
     }
</script>


<!-- Formular zum eingeben des vor und nachnamen. -->
<form action="telnr.php" method="POST">
     <div class="grob">
          <div class="ver">
               <h1 class="hanm">Telefonnummern der Gruppen</h1>

                    <div class ="eingabefeld">
                         <i class="fa fa-send icon"></i>
                         <input class="eingabefeld-text" type="text" placeholder="Gruppennr" name = "gruppennr"> 
                         <input class="eingabefeld-text" type="number" placeholder="Telefonnummer" name = "nr">
                         
                    </div>
               <input type="submit" value="Eintragen" class="btn" name="tel">
    <br> <br>

    <!-- Ausgabe der Daten aus der Datenbank, mit einem löschen button -->
    <table>
          <tr>
               <th>ID</th>
               <th>Tel. Nr</th>
               <th>Gruppe</th>
               <th>Befehle</th>
          </tr>
<?php
     $gruppe = $_SESSION['gruppe'];
     $stmt = $dbh->query("SELECT id, nr, gruppennr FROM telnr where gruppe = '$_SESSION[gruppe]' ORDER BY id");
     
     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['nr'].'</td>';
     echo '<td>'.$row['gruppennr'].'</td>';
     
?>
          <td>
               <a href="javascript:deltelnr('<?php echo $row['id'];?>',
               '<?php echo $row['nr'];?>',
               '<?php echo $row['gruppennr'];?>
               ')">Löschen</a>
          </td>

<?php 
     echo '</tr>';
     }
?>
	</table>


<!-- daten die in die Datenbank geladen werden sollen. -->
<?php

$nr = $_POST['nr'];
$gruppennr = $_POST['gruppennr'];

$gruppe = $_SESSION['gruppe'];

if(isset($_POST['tel'])){

     $sql = "INSERT INTO telnr (nr, gruppennr, gruppe) VALUES (:nr, :gruppennr, :gruppe)";
     $stmt = $dbh->prepare($sql);
     $stmt->bindValue(':nr', $nr);
     $stmt->bindValue(':gruppennr',$gruppennr);
     $stmt->bindValue(':gruppe',$gruppe);
     
     $stmt->execute();
     echo '<meta http-equiv="refresh" content="0; URL=telnr.php">';
}
?>

<?php
myFooter();
?>