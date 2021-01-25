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
if(isset($_GET['delpost'])){ 

	$stmt = $dbh->prepare('DELETE FROM post WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delpost']));

	header('Location: post.php?action=deleted');
	exit;
} 
// auswahl der daten durch sql befehl die im auswahl feld stehen
$sql = "SELECT vname FROM teilnehmer where gruppe = '$_SESSION[gruppe]' AND mitarb = 'Nein' Order By id ";

$stmt = $dbh -> prepare($sql);
$stmt -> execute();
$results = $stmt -> fetchAll();
?>

<!-- Dieser JavaScript - Teil beinhaltet eine Warnung und muss bestätigt werden, da sonst die Daten nicht gelöscht werden. -->
<script language="JavaScript" type="text/javascript">

  function delpost(id, name)
  {
	  if (confirm("Hat die folgende Person die Post abgeholt?  '" + name + "'")) {
       	window.location.href = 'post.php?delpost=' + id;
	  }
  }

</script>

<div class="grob">
    <div class="ver">
          <h1 class="hanm">Wer hat Post?</h1>
<!-- form zum auswahl der person die post hat. -->
<form action="post.php" method="post">
     <div>
          <select name="name[]">
               <option value = ""> Auswahl der Personen </option>
               <?php foreach ($results as $output) {?>

               <option> <?php echo $output ["vname"]; ?> </option>

          <?php } ?>
          </select>
     </div>
<br>
          <input id = "post" type="submit" value="Post" name="postisda">
</form>
<br>


<?php
     foreach ($_POST['name'] as $value) {

     $name = $_POST[name];
     $gruppe = $_SESSION['gruppe'];
// jzum hochloden  in  die datenbank
     if (isset($_POST[postisda])) {
          $sql = "INSERT INTO post (name, gruppe) VALUES ('".$value."', '".$gruppe."')";
          $stmt = $dbh->prepare($sql);
          $stmt -> bindValue(':name',$value);
          $stmt->bindValue(':gruppe',$gruppe);

          $stmt ->execute();
     }
}

?>

<!-- ausgabe der daten die in der Datenbank liegen in einer tabelle mit löschen befehl -->
    <table>
          <tr>
               <th>ID</th>
               <th>Vorname</th>
               <th>Eingetragen am</th>
               <th>Gruppe</th>
               <th>Löschen wenn abgeholt</th>
          </tr>
<?php
     $stmt = $dbh->query("SELECT id, name, eingetragen_am, gruppe FROM post where gruppe = '$_SESSION[gruppe]' ORDER BY id");

     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['name'].'</td>';
     echo '<td>'.date('j M Y', strtotime($row['eingetragen_am'])).'</td>';
     echo '<td>'.$row['gruppe'].'</td>';

?>
          <td>
               <a href="javascript:delpost('<?php echo $row['id'];?>',
               '<?php echo $row['name'];?>',
               '<?php echo $row['eingetragen_am'];?>',
               '<?php echo $row['gruppe'];?>')">Löschen</a>
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
