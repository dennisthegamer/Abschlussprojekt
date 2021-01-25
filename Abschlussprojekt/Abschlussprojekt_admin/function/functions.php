<!-- Diese Funktion beinhalten den HTML Teil der auf jeder Seite einhaltlich sein soll. In diesem Fall die Navigationsleiste, den Stylesheet und die Meta Angaben. -->
<?php 
error_reporting(0);
function myheader(){ ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admintool</title>
    <link rel="stylesheet" href="../style/style.css">
  <!-- für die icons wurde fontawsome eingebunden. -->
 <script src="https://use.fontawesome.com/1dd96b2ce3.js"></script>
</head>
<body>

<!-- Die Navigationsleiste befindet sich in einem DIV-Container, um einfacher sie an der richtigen stelle zu behalten. -->
<div class="nav-div">
  <!-- Die Navigationsleiste besteht aus einer 'Unordert List' mit den Links als Listen einträge. Mit CSS werden alle eigeschaften getroffen. -->
  
        <?php 
        echo ('<div id=navleistea>');
        // Zunächst wird überprüft ob ein User eingeloggt ist.
          if(isset($_SESSION["gruppe"])){
              
          
            $sesionname = $_SESSION['gruppe']; 
            
            echo ('<ul id="navleiste">');
            // Die nachfolgenden Ausgaben sind dafür da um die Seiten im Navigationsfeld anzeigen zulassen.
            echo '<img id="imglogo" src=../pics/bunteblume.jpg> ';
            echo ('<li class="navlinks"> <a href="../entries/teilnehmer.php"> Bewohner & Mitarbeiter Liste</a>  </li> ');
            echo ('<li class="navlinks"> <a href="../entries/telnr.php"> Telefonnummern der Gruppen </a>  </li> ');
            echo ('<li class="navlinks"> <a href="../entries/mitarbeiter.php"> Dienstplan </a>  </li> ');
            echo ('<li class="navlinks"> <a href="../entries/events.php">Veranstaltungen</a> </li> '); 
            echo ('<li class="navlinks"> <a href="../entries/post.php"> Post </a>  </li> ');
            echo ('<li class="navlinks"> <a href="../entries/news.php"> Nachrichten </a> </li> '); 
            echo ('<li class="navlinks"> <a href="../entries/wetter.php"> Wetter </a> </li> '); 
            echo ('<li class="navlinks"> <a href="../login/logout.php"> Logout </a>  </li> ');
        }
          
          else {
          }
          echo ('</ul>');

          echo ('</div>');
        ?>
        
  
</div>

<!-- Die Funktion dient als Endstück für den obrigen Teil. Es beinhalten die schließung des Bodys und HTML Tag. -->
<?php } function myFooter(){ ?>

  </body>

</html>
<?php } ?>
