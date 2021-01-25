<?php
session_start();
require "../function/connection.php";
require "../function/functions.php";

myheader();
 // Mit dieser if abfrage wird sichergestellt das der User eingelogt ist, wenn nicht wird er zur "login" page weitergeleitet.
if(!isset($_SESSION["gruppe"])){
     header("Location: ../login/login.php");
}

// wenn auf den Löschen button gedückt wurde wird mit der SQl anweisung der eintrag gelöscht.
if(isset($_GET['delmitarb'])){ 

	$stmt = $dbh->prepare('DELETE FROM erreichbar WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delmitarb']));

	header('Location: mitarbeiter.php?action=deleted');
	exit;
} 

// welche daten sollen angezeigt werden
$gruppe = $_SESSION['gruppe'];
$sql = "SELECT vname, mitarb, nr FROM teilnehmer where mitarb = 'Ja' AND gruppe = '$_SESSION[gruppe]' ";

$stmt = $dbh -> prepare($sql);
$stmt -> execute();
$results = $stmt -> fetchAll();
?>
<!-- Dieser JavaScript - Teil beinhaltet eine Warnung und muss bestätigt werden, da sonst die Daten nicht gelöscht werden. -->
<script language="JavaScript" type="text/javascript">

  function delmitarb(id, mitarbeiter)
  {
	  if (confirm("Hat die folgende Person kein Dienst mehr?  '" + mitarbeiter + "'")) {
       	window.location.href = 'mitarbeiter.php?delmitarb=' + id;
	  }
  }

</script>

<div class="grob">
    <div class="ver">
          <h1 class="hanm">Wer ist im Dienst? </h1>

<!-- dieser Form beinhaltet die auswahl der Person mit der jeweiligen Telnr. -->
<form action="mitarbeiter.php" method="post">
<div>
          <select name="name[]">
               <option value = ""> Auswahl des Mitarbeiters </option>
               <?php foreach ($results as $output) {?>

               <option> <?php echo $output["vname"]  . " - " . $output["nr"]?> </option>

          <?php } ?>
          </select>
     </div>
<br>
          <input id = "post" type="submit" value="Anwesend" name="mitarb">
</form>
<br>

<!-- mit diesem PHP Teil wird der ausgewählte Name in die Datenbank geladen -->
<?php
     foreach ($_POST['name'] as $value ) {
          $gruppe = $_SESSION['gruppe'];
     if (isset($_POST[mitarb])) {
          $sql = "INSERT INTO erreichbar (mitarbeiter, gruppe) VALUES ('".$value."','".$gruppe."')";
          $stmt = $dbh->prepare($sql);
          $stmt -> bindValue(':mitarbeiter',$value);
          $stmt -> bindValue(':gruppe',$gruppe);
          $stmt ->execute();
     }
}

?>
</div>
</div>


<div class="grob">
    <div class="ver">
<!-- welche Daten sollen abgerufen werden -->
    <?php 
          $gruppe = $_SESSION['gruppe'];
          $sql = "SELECT gruppennr, nr FROM telnr where gruppe = '$_SESSION[gruppe]'";

          $stmt = $dbh -> prepare($sql);
          $stmt -> execute();
          $results = $stmt -> fetchAll();
          
    ?>
          <h1 class="hanm">Welche Gruppe ist besetzt? </h1>
<!-- dieser form beinhaltet welche Gruppe ist besetz -->
<form action="mitarbeiter.php" method="post">
<div>
          <select name="gruppennr[]">
               <option value = ""> Auswahl der Gruppe </option>
               <?php foreach ($results as $output) {?>

               <option> <?php echo $output["gruppennr"]  . " - " . $output["nr"]?> </option>

          <?php } ?>
          </select>
     </div>
<br>
          <input id = "post" type="submit" value="Anwesend" name="mitarbt">
</form>
<br>
<!-- mit diesem PHP Teil wird der ausgewählte Name in die Datenbank geladen -->
<?php
     foreach ($_POST['gruppennr'] as $value ) {
          $gruppe = $_SESSION['gruppe'];
     if (isset($_POST[mitarbt])) {
          $sql = "INSERT INTO erreichbar (mitarbeiter, gruppe) VALUES ('".$value."', '".$gruppe."')";
          $stmt = $dbh->prepare($sql);
          $stmt -> bindValue(':mitarbeiter',$value);
          $stmt -> bindValue(':gruppe',$gruppe);
          echo '<meta http-equiv="refresh" content="0; URL=mitarbeiter.php">';
          $stmt ->execute();
          
     }
}

?>
<!-- eine ausgabe aller anwesenden Personen. mit löschen button -->
<table>
          <tr>
               <th>ID</th>
               <th>Mitarbeiter mit Telefonnummer</th>
               <th>Löschen wenn nicht mehr erreichbar</th>
          </tr>     
<?php
     $stmt = $dbh->query("SELECT id, mitarbeiter FROM erreichbar WHERE gruppe = '$_SESSION[gruppe]' ORDER BY id ");

     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['mitarbeiter'].'</td>';

?>
          <td>
               <a href="javascript:delmitarb('<?php echo $row['id'];?>',
               '<?php echo $row['mitarbeiter'];?>')">Löschen</a>
          </td>

<?php 
     echo '</tr>';
     }
?>
	</table> 
</div>
</div>


<?php
myFooter();
?>