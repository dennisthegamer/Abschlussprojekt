<?php
// Zunächst wir eine neue session gestartet und die geforderten Klassen aufgerufen.
session_start();
require "../function/connection.php";
require "../function/functions.php";

// Die Funktion "myheader" beinhaltet das gegebene UI, Navigationsleiste & weiteres.
myheader();

// Wenn der Benutzer auf löschen (delevent) gedrückt hat wird Mit der SQL Anweisung Das Event aus dem slider mit der bestimmten id gelöscht. Daraufhin wird in der URL angezeigt dass es gelöscht wurden ist.
if(isset($_GET['delevent'])){ 

	$stmt = $dbh->prepare('DELETE FROM events WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delevent']));

	header('Location: events.php?action=deleted');
	exit;
} 

// Das gleiche passiert nun mit dem Löschen von delevents. Nur mit den Daten aus dem Feld.
if(isset($_GET['delevents'])){ 

	$stmt = $dbh->prepare('DELETE FROM eventsnrml WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delevents']));

     header('Location: events.php?action=deleted');
	exit;
} 
?>

<!-- Dieser JavaScript - Teil beinhaltet eine Warnung und muss bestätigt werden, da sonst die Daten nicht gelöscht werden. -->
<script language="JavaScript" type="text/javascript">

  function delevent(id, vername)
  {
	  if (confirm("Sind sie sicher das sie folgende Veranstaltung löschen wollen:  '" + vername + "'"))
	  {
	  	window.location.href = 'events.php?delevent=' + id;
	  }
  }

  function delevents(id, name, wann, wo, gruppe, eingetragen_am)
  {
     if (confirm("Sind sie sicher das sie folgende Veranstaltung löschen wollen:  '" + name + "'")) {
     window.location.href = 'events.php?delevents=' + id;
     }
  }
  </script>


<div class="grob">
     <div class="ver">
     <!-- Dieses Formular beschäftigt sich Mit dem Upload eines Bildes + dem dazu gehörigen Namen für den veranstaltungsslider. -->
          <form action="events.php" method="post" enctype="multipart/form-data">
               <h1 class="hanm">Veranstaltungen im Slider</h1>
     
               <div class="eingabefeld">
                    <i class="fa fa-image icon"></i>
                    <input class="eingabefeld-text" type="text" name="vername">
               </div>

               <div class="eingabefeld">
                    <i class="fa fa-image icon"></i>
                    <input class="eingabefeld-text" type="file" name="bild"  accept="image/png, image/jpeg">
               </div>
     <input type="submit" value="Hochladen" class="btnver" name="save"> 
    <br> <br>
<!-- Dieser PHP Teil dient zum Upload des Bildes in die Datenbank mit dem dazugehörigen veranstaltungsnamen. -->
<?php
     // die zu übergebenen variablen.
     $vername = $_POST['vername'];
     $gruppe = $_SESSION['gruppe']; 
     $statusMsg = '';
     $zielpfad = "../pics/";
     $bildname = basename($_FILES["bild"]["name"]);
     $zielbildpfad = $zielpfad . $bildname;
     $fileType = pathinfo($zielbildpfad, PATHINFO_EXTENSION);

     // Erst wird überprüft ob das Formular abgesendet worden ist und nicht leer ist.
     if(isset($_POST["save"]) && !empty($_FILES["bild"]["name"])){
     require "../function/connection.php";
     // hier wird gesagt welche files erlaubt ist.
     $allowTypes = array('jpg','png','jpeg');
     if(in_array($fileType, $allowTypes)){
          // Upload file zum server.
          if(move_uploaded_file($_FILES["bild"]["tmp_name"], $zielbildpfad)){
               // einfügen des Bild in die Datenbank
               $insert = $dbh->query("INSERT into  events (vername, name, gruppe, eingetragen_am) VALUES ('".$vername."','".$bildname."', '".$gruppe."',current_timestamp)");
               // Dient als fehler quelle behebung für den User.
               if($insert){
               $statusMsg = "Das Bild ".$bildname. " wurde erfolgreich hochgeladen";
               }else{
               $statusMsg = "Hochladen fehlgeschlagen (Fehler bei MySQL Anweisung).";
               } 
          }else{
               $statusMsg = "Hochladen fehlgeschlagen.";
          }
     }else{
          $statusMsg = 'Sorry, nur JPG, JPEG & PNG Dateien können hochgeladen werden.';
     }
     }else{
     $statusMsg = 'Bitte wähle eine Datei aus die du Hochladen willst!';
     }

     // hier wird der status ausgegeben aus der if abfrage.
     echo ('<p style= "text-align:center">'. $statusMsg .'</p>');
?>

<!--Diese Tabelle gibt Die eingegeben Daten aus der Datenbank aus, mit einem löschen Button.   -->
<table>
     <tr>
          <th>ID</th>
          <th>Veranstaltungsname</th>
          <th>Dateiname</th>
          <th>Gruppe</th>
          <th>Wann eingetragen</th>
          <th>Befehle</th>
     </tr>
<?php
     $stmt = $dbh->query("SELECT id, vername, name, gruppe, eingetragen_am FROM events where gruppe = '$_SESSION[gruppe]' ORDER BY id");

     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['vername'].'</td>';
     echo '<td>'.$row['name'].'</td>';
     echo '<td>'.$row['gruppe'].'</td>';
     echo '<td>'.date('j M Y', strtotime($row['eingetragen_am'])).'</td>';
?>
     <td>
          <a href="javascript:delevent('<?php echo $row['id'];?>',
          '<?php echo $row['vername'];?>',
          '<?php echo $row['name'];?>',
          '<?php echo $row['gruppe'];?>',
          '<?php echo $row['eingetragen_am'];?>')">Löschen</a>
     </td>

<?php 
     echo '</tr>';
     }
?>
</table>
     
    </div>
</form>
<!-- Dieses Formular beschäftigt sich mit dem Hinzufügung von den Veranstaltung die im Feld angezeigt werden sollen. -->
<form action="events.php" method="POST">
    <h1 class = "hanm">Veranstaltungen im Feld</h1>
     <div class ="eingabefeld">
          <i class="fa fa-send icon"></i>
          <input  class="eingabefeld-text" type="text" placeholder="Name der Veranstaltung" name = "namev"> <br>
     </div>

     <div class ="eingabefeld">
          <i class="fa fa-send icon"></i>
          <input  class="eingabefeld-text" type="datetime-local" placeholder="Wann" name = "wann"> <br>
     </div>

     <div class ="eingabefeld">
          <i class="fa fa-send icon"></i>
          <input  class="eingabefeld-text" type="text" placeholder="Wo?" name = "wo"> <br>
     </div>
   <input type="submit" value="Senden" class="btnver" name="versave">
   
<br> <br>

<!-- Diese Tabelle spiegelt das selbe wie oben wieder, nur mit den anderen Parametern. -->
<table>
     <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Wann</th>
          <th>Wo</th>
          <th>Gruppe</th>
          <th>Eingetragen am</th>
          <th>Befehle</th>
     </tr>
<?php
     $stmt = $dbh->query("SELECT id, namev, wann, wo, gruppe, eingetragen_am FROM eventsnrml where gruppe = '$_SESSION[gruppe]' ORDER BY id");

     while($row = $stmt->fetch()){

     echo '<tr>';
     echo '<td>'.$row['id'].'</td>';
     echo '<td>'.$row['namev'].'</td>';
     echo '<td>'.date('d M Y H:i', strtotime($row['wann'])).'</td>';
     echo '<td>'.$row['wo'].'</td>';
     echo '<td>'.$row['gruppe'].'</td>';
     echo '<td>'.date('d M Y ', strtotime($row['eingetragen_am'])).'</td>';

?>
          <td>
               <a href="javascript:delevents('<?php echo $row['id'];?>',
               '<?php echo $row['namev'];?>',
               '<?php echo $row['wann'];?>',
               '<?php echo $row['wo'];?>',
               '<?php echo $row['eingetragen_am'];?>')">Löschen</a>
          </td>

<?php 
     echo '</tr>';
     }
?>
</table>
</div>
</form>

<!-- Dieser PHP - Teil beschäftigt sich mit dem Upload der Veranstaltungen In die Datenbank. -->
<?php


$namev = $_POST['namev'];
$wann = $_POST['wann'];
$wo = $_POST['wo'];
$gruppe = $_SESSION['gruppe'];

if(isset($_POST['versave'])){
     
    $sql = "INSERT INTO eventsnrml (namev, wann,  wo,  gruppe, eingetragen_am) VALUES (:namev_, :wann_, :wo_, :gruppe_, current_timestamp)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':namev_', $namev);
    $stmt->bindValue(':wann_',$wann);
    $stmt->bindValue(':gruppe_',$gruppe);
    $stmt->bindValue(':wo_', $wo);
    

    $stmt->execute();
    echo '<meta http-equiv="refresh" content="0; URL=events.php">';
}

?>


