<?php
date_default_timezone_set('Europe/Berlin');
session_start();
require "../function/connection.php";
require "../function/functions.php";

myheader();
 // Mit dieser if abfrage wird sichergestellt das der User eingelogt ist, wenn nicht wird er zur "login" page weitergeleitet.
 if(!isset($_SESSION["gruppe"])){
    header("Location: ../login/login.php");
}

//  Löschen von news.
if(isset($_GET['delnews'])){ 

	$stmt = $dbh->prepare('DELETE FROM news WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delnews']));

     header('Location: news.php?action=deleted');
	exit;
} 
?>

<!-- warnungsausgabe beim löschen, muss bestätigt bevor der Inhalt gelöscht wird. -->
<script language="JavaScript" type="text/javascript">

  function delnews(id, nachricht, datum, gruppe)
  {
	  if (confirm("Sind sie sicher das sie folgende Nachricht löschen wollen:  '" + nachricht + "'"))
	  {
	  	window.location.href = 'news.php?delnews=' + id;
	  }
  }

</script>

<!-- Dieses Formular beschäftigt sich mit dem hinzufügen neuer Nachrichten. -->
<form action="news.php" method="post">
    <div class="grob">
        <div class="ver">
            <h1 class="hanm">Nachrichten</h1>

            <div class ="eingabefeld">
               <i class="fa fa-send icon"></i>
               <input  class="eingabefeld-text" type="text" placeholder="Nachricht" name = "nachricht">
               <input type="datetime-local" name="datum">
        </div>
        <input type="submit" value="Hochladen" class="btn" name="savenews">
    </div>
</form>

<!-- Hier mit wird die Nachricht in die Datenbank geladen. -->
<?php
     $nachricht = $_POST['nachricht'];
     $datum = $_POST['datum'];
     $gruppe = $_SESSION['gruppe'];

     if(isset($_POST['savenews'])){

     $sql = "INSERT INTO news (nachricht, datum, gruppe) VALUES (:nachricht, :datum, :gruppe)";
     $stmt = $dbh->prepare($sql);
     $stmt->bindValue(':nachricht', $nachricht);
     $stmt->bindValue(':datum',$datum);
     $stmt->bindValue(':gruppe',$gruppe);

     $stmt->execute();
     }
?>

<br> <br>
     <!-- Ausgabe der Daten aus der Datenbank. Mit dem Löschen button. -->
	<table>
          <tr>
               <th>ID</th>
               <th>Nachricht</th>
               <th>Datum</th>
               <th>Gruppe</th>
               <th>Befehle</th>
          </tr>
<?php
     
     $stmt = $dbh->query("SELECT id, nachricht, datum, gruppe FROM news where gruppe = '$_SESSION[gruppe]' ORDER BY id  ");

     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['nachricht'].'</td>';
     echo '<td>'.date('d M Y H:i', strtotime($row['datum'])).'</td>';
     echo '<td>'.$row['gruppe'].'</td>';

?>
          <td>
               <a href="javascript:delnews('<?php echo $row['id'];?>',
               '<?php echo $row['nachricht'];?>',
               '<?php echo $row['datum'];?>',
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