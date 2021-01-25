<?php
session_start();
require "../function/connection.php";
require "../function/functions.php";

myheader();
 // Mit dieser if abfrage wird sichergestellt das der User eingelogt ist, wenn nicht wird er zur "login" page weitergeleitet.
 if(!isset($_SESSION["gruppe"])){
    header("Location: ../login/login.php");
}

//  Löschen des Standortes
if(isset($_GET['deltort'])){ 

	$stmt = $dbh->prepare('DELETE FROM wetter WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['deltort']));

     header('Location: wetter.php?action=deleted');
	exit;
} 
?>

<!-- Die Warnungsausgabe für das löschen eines Standortes, ebenfalls muss sie bestätgt werden. -->
<script language="JavaScript" type="text/javascript">
     
     function deltort(id, ort, gruppe) {
          if (confirm("Sind sie sicher das sie folgenden Standort löschen wollen:  '" + ort + "'")) {
               window.location.href = 'wetter.php?deltort=' + id;
          }
     }
</script>


<!-- Dieses Formular beschäftigt sich mit dem hinzufügen des neuen Standortes. -->
<form action="wetter.php" method="post">
    <div class="grob">
        <div class="ver">
            <h1 class="hanm">Wetterstandort</h1>

            <div class ="eingabefeld">
               <i class="fa fa-send icon"></i>
               <input  class="eingabefeld-text" type="text" placeholder="Standort" name = "ort">
        </div>
        <input type="submit" value="Hochladen" class="btn" name="wetternew">
    </div>
</form>


<!-- Hier mit wird der Standort in die Datenbank geladen. -->
<?php
     $ort = $_POST['ort'];
     $gruppe = $_SESSION['gruppe'];

     if(isset($_POST['wetternew'])){

     $sql = "INSERT INTO wetter (ort, gruppe) VALUES (:ort, :gruppe)";
     $stmt = $dbh->prepare($sql);
     $stmt->bindValue(':ort', $ort);
     $stmt->bindValue(':gruppe',$gruppe);

     $stmt->execute();
     }
?>

<br> <br>
     <!-- Ausgabe der Daten aus der Datenbank. Mit dem Löschen button. -->
	<table>
          <tr>
               <th>ID</th>
               <th>Standort</th>
               <th>Gruppe</th>
               <th>Befehl</th>
          </tr>
<?php
     
     $stmt = $dbh->query("SELECT id, ort, gruppe FROM wetter where gruppe = '$_SESSION[gruppe]' ORDER BY id  ");

     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['ort'].'</td>';
     echo '<td>'.$row['gruppe'].'</td>';

?>  
          <td>
               <a href="javascript:deltort('<?php echo $row['id'];?>',
               '<?php echo $row['ort'];?>',
               '<?php echo $row['gruppe'];?>')">Löschen</a>
          </td>

<?php 
     echo '</tr>';
     }
?>
	</table>

     <?php
myFooter();
?>